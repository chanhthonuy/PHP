<form action="#" method="get">
    <fieldset>
        <legend>Sort By:</legend>
        
        <label></label>
        
        <select name="name">
            <option value="SchoolName">School Name</option>
            <option value="City">City</option>
            <option value="State">State</option>
        </select>
        
        <input type="radio" name="sort" value="ASC" />Ascending
        <input type="radio" name="sort" value="DESC" />Descending

        <input type="hidden" name="action" value="sort" />
        <input type="submit" value="Sort" class="btn btn-success" />
    </fieldset>
</form>
