# Best Word match
## API
### Lobby `/api/lobby`
#### join `/join`
allows client to join a waiting room. Returns: ticket used to gain access to a game

#### web sockets
connect to realm lobby and send ticket to get updates on the lobby status. This way when the websocket connection is closed we know the user has left.
