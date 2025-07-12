<?php 
include_once "../../config/core.php";


$page_title = "Farm Details";
include_once "layout_head.php";

?>

<div class="farm-details-container">
  <form class="farm-details-form">
    <h2>Farm Information</h2>
    <table>
      <tr>
        <td><label for="town">Town:</label></td>
        <td>
          <select id="town" name="town">
            <option>Mogpog</option>
          </select>
        </td>
        <td><label for="barangay">Barangay:</label></td>
        <td>
          <select id="barangay" name="barangay">
            <option>Anapog</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><label for="farm-size">Farm Size (sqm or ha):</label></td>
        <td colspan="3">
          <input type="text" id="farm-size" name="farm-size" placeholder="e.g. 1000 sqm">
        </td>
      </tr>
      <tr>
        <td><label for="ownership-type">Ownership Type:</label></td>
        <td colspan="3">
          <select id="ownership-type" name="ownership-type">
            <option>Owned</option>
            <option>Rented</option>
            <option>Shared</option>
            <option>Others</option>
          </select>
        </td>
      </tr>
	<tr>
	  <td  >
	    <button type="submit" class="submit-button">Submit</button>
	  </td>
	</tr>
    </table>
  </form>
</div>




<?php include_once "layout_foot.php"; ?>