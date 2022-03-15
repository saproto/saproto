FROM nginx:alpine

RUN apk add openssl
RUN mkdir /etc/nginx/ssl
RUN openssl req -x509 -newkey rsa:4096 -nodes -keyout /etc/nginx/ssl/key.pem -out /etc/nginx/ssl/cert.pem -days 3650 \
        -subj "/C=NL/ST=Overijssel/L=Enschede/O=Study Association Proto/OU=Have You Tried Turning It Off And On Again committee/CN=local.saproto.nl"