'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _publicJsRequestJs = require("public/js/request.js");

var Lobby = (function () {
  function Lobby() {
    _classCallCheck(this, Lobby);

    console.log('created lobby');
  }

  _createClass(Lobby, [{
    key: 'join',
    value: function join() {
      P.coroutine(regeneratorRuntime.mark(function callee$2$0() {
        var data;
        return regeneratorRuntime.wrap(function callee$2$0$(context$3$0) {
          while (1) switch (context$3$0.prev = context$3$0.next) {
            case 0:
              context$3$0.next = 2;
              return (0, _publicJsRequestJs.request)({ url: 'api/lobby/join' });

            case 2:
              data = context$3$0.sent;

              console.log(data);

            case 4:
            case 'end':
              return context$3$0.stop();
          }
        }, callee$2$0, this);
      }));
    }
  }]);

  return Lobby;
})();

var a = new Lobby();
//# sourceMappingURL=lobby.js.map
