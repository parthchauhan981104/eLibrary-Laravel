
<script type="text/javascript">
            const search = document.getElementById('searchbar');
            const tableBody = document.getElementById('tbody');
            var categoriesradiob = $('input[name="catradios"]');
            function getContent(){

              const searchValue = search.value;
              var checked = categoriesradiob.filter(function() {
                return $(this).prop('checked');
              });
              const category = checked.val();


                  const xhr = new XMLHttpRequest();
                  xhr.open('GET','{{route('search_books')}}/?search=' + searchValue + '&categ=' + category ,true);
                  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                  xhr.onreadystatechange = function() {

                      if(xhr.readyState == 4 && xhr.status == 200)
                      {
                          tableBody.innerHTML = xhr.responseText;
                          console.log(xhr.responseText);
                      }
                  }
                  xhr.send()
            }
            search.addEventListener('input', getContent);
            for (const radiob of categoriesradiob) {
                radiob.addEventListener("click", getContent);
            }

</script>