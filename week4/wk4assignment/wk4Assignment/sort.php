
<form name="sort" action="#" method="get">
    <label>Sort By:</label>
    <select name='columns'><option value='id'>ID</option><option value='corp'>Company Name</option><option value='incorp_dt'>Date</option><option value='email'>Email</option><option value='zipcode'>Zipcode</option><option value='owner'>Owner</option><option value='phone'>Phone</option></select>    
    <input type="radio" name="sortBy" value="asc" >Ascending
    <input type="radio" name="sortBy" value="desc">Descending
    <input type="hidden" name="action" value="sort">
    <input type="submit" name="submit" value="Sort" class="btn btn-success">
   
        
    <br />
</form>

