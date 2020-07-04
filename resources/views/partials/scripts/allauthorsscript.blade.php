
<script type="text/javascript">
    const search = document.getElementById('searchbar');
    const tableBody = document.getElementById('tbody');
    function getContent(){

    const searchValue = search.value;

        const xhr = new XMLHttpRequest();
        xhr.open('GET','{{route('search_authors')}}/?search=' + searchValue ,true);
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
    search.addEventListener('input',getContent);
</script>
