# 🌱 Horta Automatizada com ESP8266 + PHP + MySQL

Este projeto registra automaticamente os dados de umidade do solo utilizando um sensor conectado a um microcontrolador ESP8266. As leituras são enviadas para um servidor local (XAMPP/WAMP), armazenadas em um banco de dados MySQL e exibidas em uma interface web com atualização em tempo real.

---

## 📦 Tecnologias Utilizadas

- **Microcontrolador**: ESP8266 (NodeMCU)
- **Sensor**: Sensor de Umidade do Solo (YL-69 ou similar)
- **Servidor local**: XAMPP (Apache + MySQL + PHP)
- **Frontend**: HTML + Bootstrap + AJAX
- **Backend**: PHP + PDO
- **Banco de dados**: MySQL

---

## ⚙️ Como Funciona

1. O ESP8266 lê o valor de umidade do solo via porta analógica.
2. A cada intervalo (ex: 10 segundos), envia uma requisição HTTP `POST` para o servidor com o valor de umidade.
3. O `insert.php` recebe o valor e o salva no banco de dados.
4. A página `exibir_medicoes.php` exibe os dados em uma tabela e gráfico, atualizando em tempo real via AJAX.

---

## 🖥️ Estrutura de Arquivos

📁 horta-automatizada/
├── codigo_arduino/
│ └── codigo_arduino.ino
├── db_class.php
├── insert.php
├── exibir_medicoes.php
├── conexao.sql # (Opcional) Script para criar a tabela MySQL
└── README.md
