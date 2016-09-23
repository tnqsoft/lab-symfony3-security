Symfony 3 Security Component Lab
=====

1) Setup
2) Command

## 1. Setup
Download and run composer
```
composer update
```

Migrations data example
customer / 123456
admin / 123456
```
php bin/console doctrine:migrations:migrate 20160923141633
```

### Virtual Host
```
<VirtualHost *:80>
    ServerName lab-symfony3-security.local
    ServerAlias lab-symfony3-security.local
	SetEnv sfEnv dev

	#For Linux
    #DocumentRoot /home/nntuan/Gits/lab-symfony3-security/web
	#For Windows
    DocumentRoot D:/projects/lab-symfony3-security/web

	#For Linux
    #<Directory /home/nntuan/Gits/lab-symfony3-security/web>
	#For windows
    <Directory D:/projects/lab-symfony3-security/web>
        #Options Indexes FollowSymLinks
        AllowOverride all
        Require all granted
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^(.*)$ app.php [QSA,L]
            RewriteCond %{HTTP:Authorization} ^(.*)
            RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
        </IfModule>
    </Directory>
    #For Ubuntu apache config
    #ErrorLog ${APACHE_LOG_DIR}/error-lab-symfony3-security.log
    #CustomLog ${APACHE_LOG_DIR}/access-lab-symfony3-security.log combined

    #For Xampp windows config
    ErrorLog "logs/error-lab-symfony3-security.log"
    CustomLog "logs/access-lab-symfony3-security.log" combined
</VirtualHost>
```

### Add Hosts File
```
127.0.0.1 lab-symfony3-security.local
```

## 2. Command Use
```
#View Log File
tail -f -n 100 /var/log/apache2/access-s3cms.log
tail -f -n 100 /var/log/apache2/error-s3cms.log

php bin/console

php bin/console cache:clear --env=dev

php bin/console assets:install --symlink web

php bin/console assetic:dump --env=dev

php bin/console doctrine:migrations:diff --env=dev

php bin/console doctrine:migrations:migrate 20160321225157 --env=dev

php bin/console generate:bundle --namespace=Tnqsoft/UserBundle --dir=src --format=annotation --no-interaction

php bin/console doctrine:generate:entities AppBundle/Entity/User

php bin/console doctrine:schema:update --force

php bin/console app:add-user
```

### Reference
[https://github.com/capistrano/symfony](https://github.com/capistrano/symfony)
