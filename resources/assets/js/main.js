import {Lobby} from './lobby'
import {Game} from './game'
class Main {
  static run () {
    rivets.configure({

      // Attribute prefix in templates
      prefix: 'rv',

      // Preload templates with initial data on bind
      preloadData: true,

      // Root sightglass interface for keypaths
      rootInterface: '.',

      // Template delimiters for text bindings
      templateDelimiters: ['{', '}']

      // Augment the event handler of the on-* binder
      // handler: function(target, event, binding) {
      //   this.call(target, event, binding.view.models)
      // }

    });
    const page = location.pathname;
    if (page.search('lobby') >= 0) {
      new Lobby();
    } else if (page.search('game') >= 0) {
      new Game();
    } else {
      new Lobby();
    }
  }
}


$(() => Main.run());
