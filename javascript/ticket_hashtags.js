function insertHashtags() {
     let description = document.getElementById('description');
     let hashtags = document.getElementById('hashtags').value.trim();

     if (hashtags !== '') {
          let hashtagsArray = hashtags.split(',');
          let newDescription = description.value;

          for (let i = 0; i < hashtagsArray.length; i++) {
               let hashtag = hashtagsArray[i].trim();

               if (hashtag !== '') {
                    newDescription += ' #' + hashtag;
               }
          }

          description.value = newDescription;
     }
}

let submitButton = document.querySelector('form button[type="submit"]');
submitButton.addEventListener('click', insertHashtags);