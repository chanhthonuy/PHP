<form action="#" method="get">
    <fieldset>
        <legend>Search:</legend>
        <label></label>
        
        <select name="name">
            <option value="SchoolName">School Name</option>
            <option value="City">City</option>
            <option value="State">State</option>
        </select>
        
        <input name="search" type="text" placeholder="Search...." />
        
        <input type="hidden" name="action" value="search" />
        <input type="submit" value="Search" class="btn btn-success" />
    </fieldset>
</form>