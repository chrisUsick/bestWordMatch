import {Lobby} from './lobby'

class Main {
  static run () {
    const page = location.pathname;
    if (page.search('lobby')) {
      new Lobby();
    } else if (page.search('game')) {

    } else {
      new Lobby();
    }
  }
}


$(() => Main.run());
