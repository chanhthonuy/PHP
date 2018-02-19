
<form name="sort" action="#" method="get">
    <label>Sort By:</label>
    <select name='columns'><option value='labUsageid'>Lab Usage ID</option><option value='studentId'>Student ID</option><option value='roomNumber'>Room Number</option><option value='dayTimeSignIn'>Time Sign In</option><option value='dayTimeSignOut'>Time Sign Out</option></select>    
    <input type="radio" name="sortBy" value="asc" >Ascending
    <input type="radio" name="sortBy" value="desc">Descending
    <input type="hidden" name="action" value="sort">
    <input type="submit" name="submit" value="Sort" class="btn btn-success">
   
        
    <br />
</form>

