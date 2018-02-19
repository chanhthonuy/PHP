
<br/>
<br/>
<form action="#" method="get" style="padding-bottom: 20px;">
    <fieldset>
        <legend>SEARCH</legend>
        <label>SEARCH BY COLUMN :</label> &nbsp;     
        <select name="searchOption">
            <option value="" disabled selected>Select your option</option>
            <option value="corp">Corporation</option>
            <option value="email">Email</option>
            <option value="id">ID</option>
            <option value="incorp_dt">Incorpt_dt</option>
            <option value="owner">Owner</option>
            <option value="phone">Phone</option>
            <option value="zipcode">ZipCode</option>
        </select>
        <input name="searchBox" type="search" placeholder="Search...." />
        <input type="hidden" name="action" value="search" />
        <br/>
        <br/>
        <input type="hidden" name="searchAction" value="search" />
        <br/>
        <br/>
        <input type="submit" value="SEARCH" class="btn-primary"/>
        &nbsp; &nbsp; &nbsp; 
        <button type="reset" class="btn-warning">RESET</button>
    </fieldset>            
</form>