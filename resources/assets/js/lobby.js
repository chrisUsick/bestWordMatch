import {request} from "./request"

class Lobby {
  constructor() {
    this.model = {
      connected:false,
      oneTicket:() => this.model.tickets == 1,
      tickets:0
     };
    console.log('created lobby');
    rivets.bind($('#lobby'), this.model);

  }

  join() {
    this.connect();
  }

  getTickets() {
    P.coroutine(function *(self){
      const tickets = yield request({url:'api/lobby/tickets'});
      console.log(tickets);
      this.model.tickets = tickets.tickets;
    }).bind(this)();
  }

  connect() {
    const ws = new WebSocket('ws://b.localhost:9000');

    ws.onclose = (event) => console.log('closed connection', event);
    ws.onopen = (event) => {
      console.log('opened', event);
      this.model.connected = true;
    }
    ws.onmessage = (e) => {
      console.log('message', e);
      const data = JSON.parse(e.data);
      if (data.method == 'lobby:updated') {
        this.getTickets();
      } else if (data.method == 'lobby:myTicket') {
        console.log('my ticket', data.ticket);
        this.model.ticket = data.ticket;
      }
    }.bind(this);

  }
}

const a = new Lobby();

a.join();
