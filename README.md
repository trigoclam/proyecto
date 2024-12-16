<VirtualHost *:80>
    ServerName proyecto.com
    DocumentRoot /var/www/proyecto.com

    <Directory /var/www/proyecto.com>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/proyecto_error.log
    CustomLog ${APACHE_LOG_DIR}/proyecto_access.log combined
</VirtualHost>
