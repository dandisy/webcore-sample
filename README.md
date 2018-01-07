## Sample of Running Webcore as Website CMS

### Installation

Copy and paste in terminal line by line, just hit Enter key

* Using Git

        git clone https://github.com/dandisy/webcore-sample.git

        cd webcore-sample

        composer install

        cp .env.example .env

Make sure your server, create "sample" database, edit .env using your favorite editor, 
for example using nano editor copy and paste this in terminal, and hit Enter key

    sudo nano .env

import sample.sql file included to your database

then

    php artisan key:generate

Now you can browse to

    http://localhost/webcore-sample/public
    or
    http://localhost/webcore-sample/public/admin

Default users are

    - superadminstrator@app.com
    - administrator@app.com
    - user@app.com

    with default password is password


#
by dandi@redbuzz.co.id
