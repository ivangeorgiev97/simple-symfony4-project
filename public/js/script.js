const categories = document.getElementById('categories');

if(categories)
{
    categories.addEventListener('click', e => {
       if(e.target.className === 'btn btn-danger delete-category') {
           if(confirm('Are you sure you want to delete this category?')) {
               const id = e.target.getAttribute('data-id');

               fetch(`/admin/category/delete/${id}`, {
                   method: 'DELETE'
               }).then(res => window.location.reload());
           }
        }
    });
}