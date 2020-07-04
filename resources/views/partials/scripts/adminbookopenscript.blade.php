
<script type="text/javascript">

  const deletebutton = document.getElementById('deletebutton');
  const bidinp = document.getElementById('bid');

  const message = document.getElementById('message');

  const savebutton = document.getElementById('savebutton');
  const authinp = document.getElementById('author_name');
  const nameinp = document.getElementById('name');
  const categinp = document.getElementById('categories');


  function edit(){

    const auth = authinp.value;
    const name = nameinp.value;
    const categ = categinp.value;
    const book_id = bidinp.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET','adm/books/?auth=' + auth + '&bid=' + book_id + '&name=' + name + '&categ=' + categ ,true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function() {

        if(xhr.readyState == 4 && xhr.status == 200)
        {
            message.innerHTML = xhr.responseText;
            $(".readbutton").css("visibility", "hidden");
            $(".readp2").css("visibility", "visible");
            console.log(xhr.responseText);
        }
    }
    xhr.send()

  }


  function del(){

    const book_id = bidinp.value;
    const auth = authinp.value;
    const name = nameinp.value;

    const xhr = new XMLHttpRequest();
    xhr.open('GET','{{route('delete_book')}}/?bid=' + book_id + '&auth=' + auth + '&name=' + name, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onreadystatechange = function() {

        if(xhr.readyState == 4 && xhr.status == 200)
        {
            message.innerHTML = xhr.responseText;
            $(".deletebutton").css("visibility", "hidden");
            $(".readp2").css("visibility", "visible");
            console.log(xhr.responseText);

            // setTimeout(function(){
            //   window.location.href = '/books';
            // }, 4000);
            // 
        }
    }
    xhr.send()

  }



  deletebutton.addEventListener('click', del);
  savebutton.addEventListener('click', edit);

</script>
