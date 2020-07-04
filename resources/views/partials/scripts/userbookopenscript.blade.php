
<script type="text/javascript">

      const readbutton = document.getElementById('readbutton');
      const message = document.getElementById('message');
      const valinp = document.getElementById('val');
      const bidinp = document.getElementById('book_id');
      const uidinp = document.getElementById('user_id');
      const authinp = document.getElementById('auth');


      function markread(){

        const val = valinp.value;
        const book_id = bidinp.value;
        const user_id = uidinp.value;
        const auth = authinp.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET','{{route('mark_read')}}/?val=' + val + '&uid=' + user_id + '&bid=' + book_id + '&auth=' + auth, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function() {

            if(xhr.readyState == 4 && xhr.status == 200)
            {
                $(".alert-success").css("visibility", "visible");
                message.innerHTML = JSON.parse(xhr.responseText);
                $(".readbutton").css("visibility", "hidden");
                $(".readp2").css("visibility", "visible");
                console.log(xhr.responseText);
            }
        }
        xhr.send()

      }

      readbutton.addEventListener('click', markread);

</script>
