self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('camtel joint').then((cache) => {
            return Promise.all([
                '/',
                '/index.html',
                '/service.html',
                '/contact.php',
                '/propos.html',
                '/styles.css',
                '/contact.css',
                '/propos.css',
                '/service.css',
                '/main.js',
                '/sw.js',
                '/manifest.json',
                'https://camtel.cm',
                'https://blue.camtel.cm',
                '/image/logo.png',
            ].map((url) => {
                return fetch(url).then((response) => {
                    if (!response.ok) {
                        throw new TypeError('Bad response status');
                    }
                    return cache.put(url, response);
                }).catch((error) => {
                    console.error('Failed to fetch & cache:', url, error);
                });
            }));
        })
    );
});
self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request,{mode:'no-cors'})
          .then(function(response) {
            // Cache hit - return response
            if (response) {
              return response;
            }
    
            // IMPORTANT: Cloner la requête.
            // Une requete est un flux et est à consommation unique
            // Il est donc nécessaire de copier la requete pour pouvoir l'utiliser et la servir
            var fetchRequest = event.request.clone();
    
            return fetch(fetchRequest).then(
              function(response) {
                if (!response || response.status !== 200 || response.type !== 'basic') {
                  return response;
                }
    
                // IMPORTANT: Même constat qu'au dessus, mais pour la mettre en cache
                var responseToCache = response.clone();
    
                caches.open('camtel joint')
                  .then(function(cache) {
                    cache.put(event.request, responseToCache);
                  });
    
                return response;
              }
            );
          })
      );
});
//supprimer cache
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.add(keyList.filter((key) => {
                if (key !== 'camtel joint') {
                    return caches.delete(key);
                }
            }));
        })
    );
});
self.addEventListener('fetch', (event) => {
    if (event.request.url.includes('/contact.php')) {
        event.respondWith(
            caches.match(event.request).then((response) => {
                return response || fetch(event.request).then((fetchResponse) => {
                    return caches.open('camtel joint').then((cache) => {
                        cache.put(event.request, fetchResponse.clone());
                        return fetchResponse;
                    });
                });
            })
        );
    }
});
const proxy = 'https://cors-anywhere.herokuapp.com/';
const target = 'https://camtel.cm/';
fetch(proxy + target)
.then((response) => response.text())
.then(data => {
    console.log(data);
});
    


            