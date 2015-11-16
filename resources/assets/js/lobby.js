import {request} from "./request"

class Lobby {
  constructor() {
    console.log('created lobby');
    rivets.bind($('#app', {connected:false}));
  }
  join() {
    this.connect();
    // let self = this;
    // P.coroutine(function *() {
    //   try{
    //     // const data = yield request({url:'api/lobby/join'});
    //     console.log('my ticket', data);
    //     self.ticket = data.ticket;
    //     // const tickets = yield request({url:'api/lobby/tickets'});
    //     // console.log('number of tickets', tickets);
    //     self.connect();
    //   } catch (e) {
    //     console.log('error', e);
    //   }
    // })();
  }

  getTickets() {
    P.coroutine(function *(self){
      const tickets = yield request({url:'api/lobby/tickets'});
      console.log(tickets);
    })(this);
  }

  connect() {
    const ws = new WebSocket('ws://b.localhost:9000');

    ws.onclose = (event) => console.log('closed connection', event);
    ws.onopen = (event) => {
      console.log('opened', event);
    }
    ws.onmessage = (e) => {
      console.log('message', e);
      const data = JSON.parse(e.data);
      if (data.method == 'lobby:updated') {
        this.getTickets();
      } else if (data.method == 'lobby:myTicket') {
        console.log('my ticket', data.ticket);
      }
    }.bind(this);

  }
}

const a = new Lobby();

a.join();
