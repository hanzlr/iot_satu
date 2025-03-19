/*  
    TUGAS BESAR 1 PERANCANGAN BERBASIS MIKROPROSESOR
    
    NAMA  : RAIHAN RAMANDHA SAPUTRA
    NIM   : 41422110039

*/

// pengaturan untuk Blynk; ID template, nama template, dan token.
#define BLYNK_PRINT Serial
#define BLYNK_TEMPLATE_ID "TMPL6P8nWcSna"
#define BLYNK_TEMPLATE_NAME "Tugas Besar 1 Perancangan Berbasis Mikroprosesor"
#define BLYNK_AUTH_TOKEN "0snxVg0DOhAg34WPRwsJnjEk_0mIF3vp"

//Include Library Arduino
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <WiFi.h>
#include <WiFiClient.h>
#include <BlynkSimpleEsp32.h>

//Inisialisasi Pin dan Variabel
int led = 16;
int ldrpin = 34;

// Deklarasikan variabel resistance, voltage, dan
  //variabel untuk menyimpan status lampu (0 = off, 1 = on)
float resistance;     
float voltage;        
int lampStatus = 0;   

//inisialisasi LCD (ALAMAT, KOLOM, BARIS)
LiquidCrystal_I2C lcd(0x27, 20, 4);

char ssid[] = "BarraIbnuHasan";
char pass[] = "barraibnuhasan12";
BlynkTimer timer;

// PWM for LED, Brightness value (0-255)
int ledBrightness = 0;     // Brightness value (0-255)

//Pengaturan Koneksi dan LCD
void setup() 
{
  pinMode(led, OUTPUT);
  pinMode(ldrpin, INPUT);
  Serial.begin(9600);

  lcd.init();
  lcd.backlight();
  lcd.setCursor(7, 0);
  lcd.print("RAIHAN");
  lcd.setCursor(2, 1);
  lcd.print("RAMANDHA SAPUTRA");
  lcd.setCursor(4, 3);
  lcd.print("41422110039");
  delay(3000);
  lcd.clear();
  
  Blynk.begin(BLYNK_AUTH_TOKEN, ssid, pass);
  timer.setInterval(1000L, sendData);
}

//Loop Utama dan Pengiriman Data
void loop() 
{
  Blynk.run();
  timer.run();
}

void sendData() 
{
  // Default by table
  const float GAMMA = 0.7;
  const float RL10 = 50;

  int analogValue = analogRead(ldrpin);

  Serial.print("Analog Value	: ");
  Serial.println(analogValue);

  // Hitung nilai
  // Convert the analog value into lux value:
  int light = analogRead(ldrpin);
  float voltage = light / 4096. * 5;
  float resistance = 2000 * voltage / (1- voltage /5);
  float lux = pow(RL10 * 1e3 * pow(10, GAMMA) / resistance, (1 / GAMMA));

  // Tampilkan nilai lux pada Serial Monitor dengan dua desimal
  Serial.print("Lux		: ");
  Serial.println(lux, 2); 

  lcd.setCursor(4, 0);
  lcd.print("STATUS LAMPU");

  // Variabel untuk status teks (On/Off)
  String textStatus;


  //Penghitungan dan Pengaturan Status Lampu  
  //Lampu Menyala 50%
  if (analogValue >= 2048 && analogValue < 3092) 
  {
    int nyala = map(light, 0, 4096, 0,128);
    ledBrightness = 128;  // 50% brightness
    analogWrite(led, nyala);  // Atur kecerahan LED
    lcd.setCursor(4, 2);
    lcd.print("Cahaya Redup");
    lcd.setCursor(1, 3);
    lcd.print("Lampu menyala: 50%");
    delay(2000);
    lcd.clear();

    Serial.print("Status Cahaya   : ");
    Serial.println("Cahaya Redup");

    lampStatus = 50;
    Serial.print("Lamp Status	: ");
    Serial.print(lampStatus);
    Serial.println("%");

    textStatus = "On";  // Status teks untuk lampu 50% menyala
    Serial.print("Status Lampu	: ");
    Serial.println(textStatus);
    Serial.print("-----------------------------");
    Serial.println();

    } 
  
  // Kondisi lampu menyala 100%
  else if (analogValue >= 3092) 
  {
    int nyala = map(light, 0, 4096, 0,255);
    ledBrightness = 255;  // 100% brightness
    analogWrite(led, ledBrightness);  // Atur kecerahan LED
    lcd.setCursor(4, 2);
    lcd.print("Cahaya Gelap");
    lcd.setCursor(1, 3);
    lcd.print("Lampu menyala:100%");

    Serial.print("Status Cahaya   : ");
    Serial.println("Cahaya Gelap");

    lampStatus = 100;
    Serial.print("Lamp Status	: ");
    Serial.print(lampStatus);
    Serial.println("%"); 

    // Status teks untuk lampu 100% menyala
    textStatus = "On";  
    Serial.print("Status Lampu	: ");
    Serial.println(textStatus);
    Serial.print("-----------------------------");
    Serial.println();
    delay(2000);
    lcd.clear();
  } 
  
  // Kondisi lampu mati
  else 
  {
    ledBrightness = 0;  // Lampu mati
    analogWrite(led, ledBrightness);  // Matikan LED
    lcd.setCursor(4, 2);
    lcd.print("Cahaya Terang");
    lcd.setCursor(5, 3);
    lcd.print("Lampu Mati");
    lampStatus = 0;
    Serial.print("Lamp Status	: ");
    Serial.print(lampStatus);
    Serial.println("%");

    Serial.print("Status Cahaya   : ");
    Serial.println("Cahaya Terang");    

    textStatus = "Off";  // Status teks untuk lampu mati
    Serial.print("Status Lampu	: ");

    Serial.println(textStatus);
    Serial.print("-----------------------------");
    Serial.println();
    delay(2000);
    lcd.clear();
  }

    // Kirim data ke Blynk
  Blynk.virtualWrite(V0, analogValue);  // Nilai analog sensor
  Blynk.virtualWrite(V1, lux);          // Nilai lux
  Blynk.virtualWrite(V4, lampStatus);   // Status lampu (0, 50, 100)
  
  // Kirim status lampu as text to Blynk (On/Off)
  Blynk.virtualWrite(V3, textStatus);   // Status teks (On atau Off)

} //End Void sendData()
  