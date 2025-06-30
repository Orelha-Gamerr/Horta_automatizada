#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

const char* ssid = "IFSC";
const char* password = "campuschapeco";

const char* serverUrl = "http://172.21.98.14/Horta_automatizada/insert.php"; // Ex: http://192.168.0.100/insert.php

const int sensorPin = A0;

WiFiClient client;

void setup() {
  Serial.begin(115200);
  WiFi.begin(ssid, password);
  Serial.print("Conectando ao Wi-Fi");

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\nWi-Fi conectado");
  Serial.print("ESP IP: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  int leitura = analogRead(sensorPin);
  int umidade = map(leitura, 1023, 0, 0, 100);

  Serial.print("Umidade: ");
  Serial.print(umidade);
  Serial.println("%");

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(client, serverUrl);
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    String postData = "umidade=" + String(umidade);
    int httpCode = http.POST(postData);

    Serial.print("Código HTTP: ");
    Serial.println(httpCode);

    if (httpCode <= 0) {
      Serial.print("Erro HTTP: ");
      Serial.println(http.errorToString(httpCode).c_str());
    }

    http.end();
  } else {
    Serial.println("ESP desconectado do Wi-Fi!");
  }

  delay(10000); // Aguarda 10 segundos
}
