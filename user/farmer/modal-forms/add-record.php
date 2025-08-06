<div id="ap-modal" class="ap-modal">
    <div class="addproduct-content-modal">
        <span class="close">&times;</span>
        <form action='<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>"' method='post'>
            <div class="AR-content">
                <table>
                    <tr>
                        <td>
                            <span>name</span>
                            <input type="text" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Type</span>
                            <select name="" id="" required>
                                <option value="vegetable">Vegetable</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Quantity</span>
                            <input type="text" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Cost</span>
                            <input type="text" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Date</span>
                            <input type="date">    
                        </td>
                    <tr>
                        <td><Button>Save</Button></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>