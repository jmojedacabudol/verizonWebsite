<?php
if (isset($_POST['propertyId'])) {

    require_once 'dbh.inc.php';
    $propertyId = $_POST['propertyId'];

    $sql = "SELECT * FROM property WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="form-group row">';
            echo '<label for="elisting-title" class="col-4 col-form-label">Listing
          Title</label>';
            echo '<div class="col-8">';
            echo '<input name="listing-title" placeholder="Enter Listing Title" value="';
            echo $row['propertyname'] . '"';
            echo 'class="form-control here" type="text">';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>';
            echo '<div class="col-8">';
            echo "<select name='listing-offer-type' onchange='showRentOptions(this.value)' class='form-control'>";
            if ($row['offertype'] == 'Sell') {
                echo '<option selected>Sell</option>
          <option>Rent</option>
          <option>Presell</option>';
            } else if ($row['offertype'] == 'Rent') {
                echo '<option >Sell</option>
            <option selected>Rent</option>
            <option>Presell</option>';
            } else if ($row['offertype'] == 'Presell') {
                echo '<option >Sell</option>
            <option selected>Rent</option>
            <option>Presell</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="location" class="col-4 col-form-label">Location</label>';
            echo '<div class="col-8">';
            echo '<div class="input-group w-100">';
            echo '<div class="input-group-prepend">';
            echo '<span class="input-group-text" id="basic-addon1"><i class="fas fa-map-marker-alt"></i></span>';
            echo '</div>';
            echo '<input type="text" name="listing-location" value="';
            echo $row['propertylocation'] . '"';
            echo 'class="form-control" placeholder="Enter Location" aria-label="Location" aria-describedby="basic-addon1">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="location" class="col-4 col-form-label">Price (₱)</label>';
            echo '<div class="col-8">';
            echo '<div class="input-group w-100">';
            if ($row['offertype'] == "Sell") {
                echo '<input type="text" id="eofferchoice" name="listing-rentChoice" style="display:none;" value="none">';
                echo '<input type="text" class="form-control" placeholder="Enter Amount" aria-label="Price" value="';
                echo $row['propertyamount'] . '"';
                echo 'name="listing-price" aria-describedby="basic-addon2">';

                echo '<div class="input-group-append" id="erentBtn" style="display:none;">';
                echo '<button class="btn btn-primary" onclick="checkRentChoice(this.id)" id="edailyBtn" type="button">Daily</button>';
                echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="eweeklyBtn" type="button">Weekly</button>';
                echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="emonthlyBtn" type="button">Monthly</button>';
            } else if ($row['offertype'] == "Rent") {
                if ($row['propertyrentchoice'] == 'Daily') {
                    echo '<input type="text" id="eofferchoice" value="';
                    echo $row['propertyrentchoice'] . '"';
                    echo 'name="listing-rentChoice" style="display:none;" value="none">';
                    echo '<input type="text" class="form-control" placeholder="Enter Amount" aria-label="Price" value="';
                    echo $row['propertyamount'] . '"';
                    echo 'name="listing-price" aria-describedby="basic-addon2">';

                    echo '<div class="input-group-append" id="erentBtn">';
                    echo '<button class="btn btn-primary" onclick="checkRentChoice(this.id)" id="edailyBtn" type="button">Daily</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="eweeklyBtn" type="button">Weekly</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="emonthlyBtn" type="button">Monthly</button>';
                } else if ($row['propertyrentchoice'] == 'Weekly') {
                    echo '<input type="text" id="eofferchoice" value="';
                    echo $row['propertyrentchoice'] . '"';
                    echo 'name="listing-rentChoice" style="display:none;" value="none">';
                    echo '<input type="text" class="form-control" placeholder="Enter Amount" aria-label="Price" value="';
                    echo $row['propertyamount'] . '"';
                    echo 'name="listing-price" aria-describedby="basic-addon2">';

                    echo '<div class="input-group-append" id="erentBtn" >';
                    echo '<button class="btn btn-primary" onclick="checkRentChoice(this.id)" id="edailyBtn" type="button">Daily</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="eweeklyBtn" type="button">Weekly</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="emonthlyBtn" type="button">Monthly</button>';
                } else if ($row['propertyrentchoice'] == 'Monthly') {
                    echo '<input type="text" id="eofferchoice" value="';
                    echo $row['propertyrentchoice'] . '"';
                    echo 'name="listing-rentChoice" style="display:none;" value="none">';
                    echo '<input type="text" class="form-control" placeholder="Enter Amount" aria-label="Price" value="';
                    echo $row['propertyamount'] . '"';
                    echo 'name="listing-price" aria-describedby="basic-addon2">';

                    echo '<div class="input-group-append" id="erentBtn" >';
                    echo '<button class="btn btn-primary" onclick="checkRentChoice(this.id)" id="edailyBtn" type="button">Daily</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="eweeklyBtn" type="button">Weekly</button>';
                    echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="emonthlyBtn" type="button">Monthly</button>';
                }
            } else if ($row['offertype'] == 'Presell') {
                echo '<input type="text" id="eofferchoice" name="listing-rentChoice" style="display:none;" value="none">';
                echo '<input type="text" class="form-control" placeholder="Enter Amount" aria-label="Price" value="';
                echo $row['propertyamount'] . '"';
                echo 'name="listing-price" aria-describedby="basic-addon2">';

                echo '<div class="input-group-append" id="rentBtn" style="display:none;">';
                echo '<button class="btn btn-primary" onclick="checkRentChoice(this.id)" id="edailyBtn" type="button">Daily</button>';
                echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="eweeklyBtn" type="button">Weekly</button>';
                echo '<button class="btn btn-secondary" onclick="checkRentChoice(this.id)" id="emonthlyBtn" type="button">Monthly</button>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="listing-type" class="col-4 col-form-label">Property Type</label>';
            echo '<div class="col-8">';
            echo '<select id="elisting-type" name="listing-type" class="form-control">';
            if ($row['propertytype'] == 'Building') {
                echo '<option >Building</option>
                <option>Condominium</option>
                <option>Farm Lots</option>
                <option>House</option>
                <option>Industrial</option>
                <option>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'Condominium') {
                echo '<option>Building</option>
                <option selected>Condominium</option>
                <option>Farm Lots</option>
                <option>House</option>
                <option>Industrial</option>
                <option>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'Farm Lots') {
                echo '<option>Building</option>
                <option>Condominium</option>
                <option selected>Farm Lots</option>
                <option>House</option>
                <option>Industrial</option>
                <option>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'House') {
                echo '<option>Building</option>
                <option>Condominium</option>
                <option>Farm Lots</option>
                <option selected>House</option>
                <option>Industrial</option>
                <option>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'Industrial') {
                echo '<option>Building</option>
                <option>Condominium</option>
                <option>Farm Lots</option>
                <option>House</option>
                <option selected>Industrial</option>
                <option>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'Offices') {
                echo '<option>Building</option>
                <option>Condominium</option>
                <option>Farm Lots</option>
                <option>House</option>
                <option>Industrial</option>
                <option selected>Offices</option>
                <option>Warehouse</option>';
            } else if ($row['propertytype'] == 'Warehouse') {
                echo '<option>Building</option>
                <option>Condominium</option>
                <option>Farm Lots</option>
                <option>House</option>
                <option>Industrial</option>
                <option>Offices</option>
                <option selected>Warehouse</option>';
            }
            echo "</select>";
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="onlyNumbers1" class="col-4 col-form-label">Lot Area (per
            sqm)</label>';
            echo '<div class="col-8">';
            echo '<input type="text" class="form-control" placeholder="0" value="';
            echo $row['propertylotarea'] . '"';
            echo 'name="listing-lot-area" aria-label="" aria-describedby="button-addon3">';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="onlyNumbers2" class="col-4 col-form-label">Floor Area (per
            sqm)*</label>';
            echo '<div class="col-8">';
            echo '<input type="text" class="form-control" placeholder="0" value="';
            echo $row['propertyfloorarea'] . '"';
            echo 'id="elisting-floor-area" name="listing-floor-area" aria-label="" aria-describedby="button-addon3">';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>';
            echo '<div class="col-8">';
            echo '<input type="number" min="1" max="10" class="form-control" placeholder="0" id="elisting-bedroom" name="listing-bedroom" onkeypress="return isNumber(event)" value="';
            echo $row['propertybedrooms'] . '"';
            echo 'onpaste="return false;" aria-label="" aria-describedby="button-addon3" >';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="carpark" class="col-4 col-form-label">No. of Carparks</label>';
            echo '<div class="col-8">';
            echo '  <input type="number" min="0" max="10" value ="';
            echo $row['propertycarpark'] . '"';
            echo'class="form-control" placeholder="0" id="elisting-carpark" name="listing-carpark" onkeypress="return isNumber(event)" onpaste="return false;" aria-label="" aria-describedby="button-addon3">';
            echo '</div>';
            echo '</div>';
            echo '<div class="form-group row">';
            echo '<label for="listing-desc" class="col-4 col-form-label">Description</label>';
            echo '<div class="col-8">';
            echo '<textarea class="form-control" style="height: 150px;" name="listing-desc" id="elisting-desc">';
            echo $row['propertydesc'];
            echo'</textarea>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        mysqli_close($conn);
    }
}
