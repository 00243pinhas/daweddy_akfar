// favorites.js (vanilla JS)
document.addEventListener('DOMContentLoaded', function () {
  if ( typeof favoritesObj === 'undefined' ) return;

  // handle heart clicks
  document.querySelectorAll('.heart-icon').forEach(function(el) {
    el.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation(); 

    
    
      var postId = parseInt(this.dataset.postId, 10);

      console.log(postId);


      if (! favoritesObj.is_user_logged_in ) {
        window.location.href = favoritesObj.login_url + '?redirect_to=' + encodeURIComponent(window.location.href);
        return;
      }

      // visual feedback: disable while request runs
      this.classList.add('loading');

      var body = new URLSearchParams();

      body.append('action', 'toggle_favorite');
      body.append('post_id', postId);
      body.append('nonce', favoritesObj.nonce);


      fetch(favoritesObj.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
        body: body.toString()
      })
      .then(function(res){ return res.json(); })
      .then(function(json){
        el.classList.remove('loading');

        if (json.success) {
            if (json.data.status === 'added') {
            el.classList.add('liked');
            if (el.querySelector('i')) {
                el.querySelector('i').classList.remove('bi-heart');
                el.querySelector('i').classList.add('bi-heart-fill');
            }
            } else if (json.data.status === 'removed') {
            el.classList.remove('liked');
            if (el.querySelector('i')) {
                el.querySelector('i').classList.remove('bi-heart-fill');
                el.querySelector('i').classList.add('bi-heart');
            }
            }


          window.dispatchEvent(new CustomEvent('favorites-updated', { detail: { count: json.data.favorites.length, favorites: json.data.favorites } }));
        } else {
          // error
          if (json.data && json.data.message === 'login_required') {
            window.location.href = json.data.login_url + '?redirect_to=' + encodeURIComponent(window.location.href);
          } else {
            console.error(json);
          }
        }
      })
      .catch(function(err){
        el.classList.remove('loading');
        console.error('AJAX error', err);

        console.error('Fetch error:', err);
      });

    });
  });

});


