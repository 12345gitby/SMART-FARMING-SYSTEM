import network
import socket
import time
import random  # Using the standard 'random' module for generating random values

# Wi-Fi credentials
ssid = "nupendra"
password = "nupendra"

# Server IP address
server_ip = "192.168.98.74"  # Replace with your server's IP address
server_port = 80  # Default HTTP port

# Function to connect to Wi-Fi
def connect_wifi():
    wlan = network.WLAN(network.STA_IF)
    wlan.active(True)
    if not wlan.isconnected():
        print('Connecting to network...')
        wlan.connect(ssid, password)
        while not wlan.isconnected():
            time.sleep(1)
            print("Attempting to connect...")
    print('Network connected:', wlan.ifconfig())

# Function to generate random sensor data
def generate_sensor_data():
    moisture = random.uniform(20.0, 40.0)  # Random moisture between 20% and 40%
    temperature = random.uniform(20.0, 35.0)  # Random temperature between 20°C and 35°C
    nitrogen = random.randint(200, 400)  # Random nitrogen between 200 mg/kg and 400 mg/kg
    phosphorus = random.uniform(5.0, 10.0)  # Random phosphorus between 5 mg/kg and 10 mg/kg
    potassium = random.uniform(5.0, 15.0)  # Random potassium between 5 mg/kg and 15 mg/kg
    return moisture, temperature, nitrogen, phosphorus, potassium

# Function to send data to the server
def send_data_to_php(moisture, temperature, nitrogen, phosphorus, potassium):
    try:
        addr = socket.getaddrinfo(server_ip, server_port)[0][-1]
        s = socket.socket()
        s.connect(addr)
        
        # Prepare the GET request with sensor data
        url = f"/jays_major_project/html/ltr/connect.php?moisture={moisture}&temperature={temperature}&nitrogen={nitrogen}&phosphorus={phosphorus}&potassium={potassium}"
        request = f"GET {url} HTTP/1.1\r\nHost: {server_ip}\r\nConnection: close\r\n\r\n"
        
        print(f"Sending request: {request}")
        
        # Send the request
        s.send(request.encode())
        
        # Receive server response
        response = s.recv(1024)
        print('Server response:', response.decode())
        
        # Close the connection
        s.close()
    except Exception as e:
        print("Error while sending data:", str(e))

# Main program loop
def main():
    connect_wifi()  # Connect to Wi-Fi
    
    while True:
        # Generate random sensor data
        moisture, temperature, nitrogen, phosphorus, potassium = generate_sensor_data()
        
        print(f"Generated data - Moisture: {moisture}, Temperature: {temperature}, Nitrogen: {nitrogen}, Phosphorus: {phosphorus}, Potassium: {potassium}")
        
        # Send the data to the server
        send_data_to_php(moisture, temperature, nitrogen, phosphorus, potassium)
        
        # Wait before sending the next data (e.g., 10 seconds)
        time.sleep(10)

# Run the main loop
main()

