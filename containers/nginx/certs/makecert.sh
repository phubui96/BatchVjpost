#!/usr/bin/env sh

# Generate a private key
openssl genrsa -out server.key 2048

# Generate a signing request from your private key
openssl req -new -sha256 -key server.key -subj "/name= Batch" -out server.csr

# Create a server certificate by signing the signing request with your private key
openssl x509 -req -sha256 -days 825 -signkey server.key -extfile sans.txt -in server.csr -out server.crt

# Check the contents of the server certificate
openssl x509 -in server.crt -text -noout
