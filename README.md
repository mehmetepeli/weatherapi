## to install

    docker installed and running
    git clone git@github.com:mehmetepeli/weatherapi.git

    cd weatherapi
    docker-compose up / vendor/bin/sail up

Our api need GET method like this GET /api/v3/cities/{id}?date={date}

GET /api/v3/cities?date={date}
GET /api/v3/cities/{id}?date={date}

payload:{
   date:{date}
}