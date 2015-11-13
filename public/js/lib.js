"use strict";

function request() {
  var req = new XMLHttpRequest();
  return new Promise(function (resolve, reject) {
    req.open(method, url);
    req.onreadystatechange = function () {
      if (req.readyState == 4 && req.status == 200) {
        resolve(JSON.parse(req.responseText));
      } else if (req.readyState == 4) {
        reject(req);
      }
    };
    req.send();
  });
}
//# sourceMappingURL=lib.js.map
