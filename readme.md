# Best Word match
## API
### Lobby `/api/lobby`
#### join `/join`
allows client to join a waiting room. Returns: ticket used to gain access to a game

#### web sockets
connect to realm lobby and send ticket to get updates on the lobby status. This way when the websocket connection is closed we know the user has left.

## virtualization
docker-compose currently not working     

build image: docker build -t bwm_web .

docker run -d -p 8000:80 -p 9000:9000 -v ///c/Users/chris/p/bestWordMatch/:/share --link redis:redis bwm_web  

run the web server: `docker exec -d  container_id php artisan ws:serve`  

connect to running docker: `winpty docker exec -i -t container_id bash` remember to run websocket server.

Note: nginx is being bad and serving old files.
