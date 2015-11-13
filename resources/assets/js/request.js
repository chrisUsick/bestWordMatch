export function request ({method = 'GET', url}) {
  let req = new XMLHttpRequest();
  return new P((resolve, reject) => {
    req.open(method, url);
    req.onreadystatechange = () => {
      if (req.readyState == 4 && req.status == 200){
        resolve(JSON.parse(req.responseText));
      } else if (req.readyState == 4){
        reject(req);
      }
    }
    req.send();
  });
}
