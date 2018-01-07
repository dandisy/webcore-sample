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

### Screenshots

* Sample front page

![alt text](https://github.com/dandisy/webcore-screenshots/blob/master/sample%20front%20page.png "Logo Title Text 1")

* Login page

![login page](https://drive.google.com/file/d/1Gu-GhVUrgQQouVnBf77yN5t-pDZl3m2z/view)

* Admin page

![admin page 1](https://drive.google.com/file/d/1wpVnVieuJTNOcfUlRtkmxRiZyXI1fsod/view)

![admin page 2](https://drive.google.com/file/d/1UaTmLf8o5z7NM95CyIbyJfOj1QguT53n/view)

![admin page 3](https://drive.google.com/file/d/1Dj-1A7V0HtJafh8ZdcfTTissHs_L7JEq/view)

![admin page 4](https://drive.google.com/file/d/1Tk0QkjUTZkFVXmWoCDNBxVP5fsoPtTDN/view)


#
by dandi@redbuzz.co.id
