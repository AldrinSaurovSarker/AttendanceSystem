#include <Adafruit_Fingerprint.h>
#include <string>
#include <WiFi.h>
#include "FirebaseESP32.h"

#define FIREBASE_HOST "attendance-system-6d7a6-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "AIzaSyCI03PF-cz7jkTJxx9lSJt7uy4OSy_mVHM"
#define WIFI_SSID "Villa"
#define WIFI_PASSWORD "87654321"

FirebaseData firebaseData;
HardwareSerial mySerial(2);
Adafruit_Fingerprint finger = Adafruit_Fingerprint(&mySerial);
uint8_t p = -1;
int counter = 1;

void setup()
{
    Serial.begin(9600);
    initWifi();

    while (!Serial);
    delay(100);

    Serial.println("\n\nAdafruit Fingerprint sensor enrollment");
    finger.begin(57600);

    if (finger.verifyPassword())
    {
        Serial.println("Found fingerprint sensor!");
    }
    else
    {
        Serial.println("Did not find fingerprint sensor :(");
        while (1)
        {
            delay(1);
        }
    }

    Serial.println(F("Reading sensor parameters"));
    finger.getParameters();
    Serial.print(F("Status: 0x"));
    Serial.println(finger.status_reg, HEX);
    Serial.print(F("Sys ID: 0x"));
    Serial.println(finger.system_id, HEX);
    Serial.print(F("Capacity: "));
    Serial.println(finger.capacity);
    Serial.print(F("Security level: "));
    Serial.println(finger.security_level);
    Serial.print(F("Device address: "));
    Serial.println(finger.device_addr, HEX);
    Serial.print(F("Packet len: "));
    Serial.println(finger.packet_len);
    Serial.print(F("Baud rate: "));
    Serial.println(finger.baud_rate);
}

void initWifi()
{
    WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
    Serial.print("Connecting to Wi-Fi");

    while (WiFi.status() != WL_CONNECTED)
    {
        Serial.print(".");
        delay(300);
    }

    Serial.println();
    Serial.print("Connected with IP: ");
    Serial.println(WiFi.localIP());
    Serial.println();

    Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
    Firebase.reconnectWiFi(true);
}

void loop()
{
    if (counter == 1) {
        Serial.println("Enter an option...");
        Serial.println("'e' -> enroll");
        Serial.println("'v' -> verify");
        Serial.println("'c' -> clear database");
        Serial.println();
    }
    
    if (Serial.available()>0) {
        switch(Serial.read())
        {
            case 'e':
                enrollFingerprint();
                counter = 1;
                break;
                
            case 'v':
                verifyFingerprint();
                counter = 1;
                break;
            case 'c':
                deleteFingerprint();
                counter = 1;
                break;
        }
    }
    
    counter = 0;
}

void deleteFingerprint()
{
  finger.emptyDatabase();
  Serial.println("Now database is empty :)");
}
        
void enrollFingerprint()
{
    int id = readnumber();

    Serial.println("Place finger on the fingerprint sensor...");
    readFingerprintSensor();
    finger.image2Tz(1);

    Serial.println("Place the same finger again...");
    readFingerprintSensor();
    finger.image2Tz(2);

    createFingerprintTemplate(id);
    loadFingerprintTemplate(id);

    String data = readFingerprintTemplate();
    sendToFirebase(id, data);
}
    
void verifyFingerprint()
{
    Serial.println("Place finger on the fingerprint sensor...");
    readFingerprintSensor();
    finger.image2Tz();
    
    int id = getFingerprintID();
    loadFingerprintTemplate(id);
    
    String data = readFingerprintTemplate();
    sendToFirebase(id, data);
}

uint8_t readnumber(void)
{
    Serial.println("Please type in the ID...");
    uint8_t num = 0;

    while (num == 0)
    {
        while (!Serial.available());
        num = Serial.parseInt();
    }
    return num;
}

void readFingerprintSensor()
{
    p = -1;
    while (p != FINGERPRINT_OK)
    {
        p = finger.getImage();
        switch (p)
        {
        case FINGERPRINT_OK:
            Serial.println("Image taken");
            break;
        case FINGERPRINT_NOFINGER:
            break;
        case FINGERPRINT_PACKETRECIEVEERR:
            Serial.println("Communication error");
            break;
        case FINGERPRINT_IMAGEFAIL:
            Serial.println("Imaging error");
            break;
        default:
            Serial.println("Unknown error");
            break;
        }
    }
}

void createFingerprintTemplate(int id)
{
    finger.createModel();
    if (p == FINGERPRINT_OK)
    {
        Serial.println("Prints matched!");
    }
    else if (p == FINGERPRINT_PACKETRECIEVEERR)
    {
        Serial.println("Communication error");
    }
    else if (p == FINGERPRINT_ENROLLMISMATCH)
    {
        Serial.println("Fingerprints did not match");
    }
    else
    {
        Serial.println("Unknown error");
    }

    p = finger.storeModel(id);
    if (p == FINGERPRINT_OK)
    {
        Serial.println("Stored!");
    }
    else if (p == FINGERPRINT_PACKETRECIEVEERR)
    {
        Serial.println("Communication error");
    }
    else if (p == FINGERPRINT_BADLOCATION)
    {
        Serial.println("Could not store in that location");
    }
    else if (p == FINGERPRINT_FLASHERR)
    {
        Serial.println("Error writing to flash");
    }
    else
    {
        Serial.println("Unknown error");
    }
}

void loadFingerprintTemplate(int id)
{
    p = finger.loadModel(id);
    switch (p)
    {
    case FINGERPRINT_OK:
        Serial.print("Template ");
        Serial.print(id);
        Serial.println(" loaded");
        break;
    case FINGERPRINT_PACKETRECIEVEERR:
        Serial.println("Communication error");

    default:
        Serial.print("Unknown error ");
        Serial.println(p);
    }

    Serial.print("Attempting to get #");
    Serial.println(id);
    p = finger.getModel();

    switch (p)
    {
    case FINGERPRINT_OK:
        Serial.print("Template ");
        Serial.print(id);
        Serial.println(" transferring:");
        break;
    default:
        Serial.print("Unknown error ");
        Serial.println(p);
    }
}

String readFingerprintTemplate()
{
    uint8_t bytesReceived[534];
    memset(bytesReceived, 0xff, 534);
    uint32_t starttime = millis();
    int i = 0;

    while (i < 534 && (millis() - starttime) < 20000)
    {
        if (mySerial.available())
        {
            bytesReceived[i++] = mySerial.read();
        }
    }

    Serial.print(i);
    Serial.println("Bytes read.");
    Serial.println("Decoding packet...");

    uint8_t fingerTemplate[512];
    memset(fingerTemplate, 0xff, 512);

    int uindx = 9, index = 0;
    memcpy(fingerTemplate + index, bytesReceived + uindx, 256);
    uindx += 256;
    uindx += 2;
    uindx += 9;
    index += 256;
    memcpy(fingerTemplate + index, bytesReceived + uindx, 256);

    String result;
    for (int i = 0; i < 512; ++i)
    {
        result += getHex(fingerTemplate[i], 2);
    }
    Serial.println(result);
    Serial.println("\nDone.");

    return result;
}

String getHex(int num, int precision)
{
    char tmp[16];
    char format[128];

    sprintf(format, "%%.%dX", precision);
    sprintf(tmp, format, num);
    return String(tmp);
}

void sendToFirebase(int id, String data)
{
    Firebase.setString(firebaseData, "/Fingerprints/temp/id", String(id));
    Firebase.setString(firebaseData, "/Fingerprints/temp/fingerHex", data);
}

uint8_t getFingerprintID()
{
    p = finger.fingerSearch();
    if (p == FINGERPRINT_OK)
    {
        Serial.println("Found a print match!");
    }
    else if (p == FINGERPRINT_PACKETRECIEVEERR)
    {
        Serial.println("Communication error");
        return p;
    }
    else if (p == FINGERPRINT_NOTFOUND)
    {
        Serial.println("Did not find a match");
        return p;
    }
    else
    {
        Serial.println("Unknown error");
        return p;
    }

    Serial.print("Found ID #");
    Serial.print(finger.fingerID);
    Serial.print(" with confidence of ");
    Serial.println(finger.confidence);

    return finger.fingerID;
}