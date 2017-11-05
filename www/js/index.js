JavaScript

      var app = {

          initialize: function() {
              this.bindEvents();
          },
         
          bindEvents: function() {
              var takePhoto = document.getElementById('takePhoto');
              takePhoto.addEventListener('click', app.takePhoto, false);
              var sendPhoto = document.getElementById('sendPhoto');
              sendPhoto.addEventListener('click', app.sendPhoto, false);
          },

          sendPhoto: function() {
              alert('Imagen enviada al servidor');
          },

          takePhoto: function(){
              navigator.camera.getPicture(app.onPhotoDataSuccess, app.onFail, { quality: 20, 
                  allowEdit: true, destinationType: navigator.camera.DestinationType.DATA_URL });
          },

          onPhotoDataSuccess: function(imageData) {
         
            var photo = document.getElementById('photo');

            photo.style.display = 'block';

            photo.src = "data:image/jpeg;base64," + imageData;

            var sendPhoto = document.getElementById('sendPhoto');
            sendPhoto.style.display = 'block';
            
          },

          onFail: function(message) {
            alert('Failed because: ' + message);
          }

      };
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
      var app = {
 
          initialize: function() {
              this.bindEvents();
          },
         
          bindEvents: function() {
              var takePhoto = document.getElementById('takePhoto');
              takePhoto.addEventListener('click', app.takePhoto, false);
              var sendPhoto = document.getElementById('sendPhoto');
              sendPhoto.addEventListener('click', app.sendPhoto, false);
          },
 
          sendPhoto: function() {
              alert('Imagen enviada al servidor');
          },
 
          takePhoto: function(){
              navigator.camera.getPicture(app.onPhotoDataSuccess, app.onFail, { quality: 20, 
                  allowEdit: true, destinationType: navigator.camera.DestinationType.DATA_URL });
          },
 
          onPhotoDataSuccess: function(imageData) {
         
            var photo = document.getElementById('photo');
 
            photo.style.display = 'block';
 
            photo.src = "data:image/jpeg;base64," + imageData;
 
            var sendPhoto = document.getElementById('sendPhoto');
            sendPhoto.style.display = 'block';
            
          },
 
          onFail: function(message) {
            alert('Failed because: ' + message);
          }
 
      };