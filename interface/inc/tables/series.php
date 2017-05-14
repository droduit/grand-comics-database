
<tr><td><label for="name">Name</label></td><td><input type="text" id="name" name="name" placeholder="Name" required="required" maxlength="240"  /></td></tr>
<tr><td><label for="format">Format</label></td><td><textarea type="text" id="format" name="format" placeholder="Format"></textarea></td></tr>
<tr><td><label for="first_issue_id">First issue ID</label></td><td><textarea type="text" id="first_issue_id" name="first_issue_id"></textarea></td></tr>
<tr><td><label for="last_issue_id">Last issue ID</label></td><td><textarea type="text" id="last_issue_id" name="last_issue_id" ></textarea></td></tr>

<tr><td><label for="publisher_id">Publisher ID</label></td><td><textarea type="text" id="publisher_id" name="publisher_id"></textarea></td></tr>
<tr><td><label for="country_id">Country</label></td><td> <?= getSelectComponent($db, 'country'); ?> </td></tr>

<tr><td><label for="language_id">Language</label></td><td><?= getSelectComponent($db, 'language'); ?></td></tr>

<tr><td><label for="notes">Notes</label></td><td><textarea id="notes" name="notes" placeholder="Notes"></textarea></td></tr>
<tr><td><label for="color">Color</label></td><td><textarea id="color" name="color" placeholder="Color"></textarea></td></tr>
<tr><td><label for="dimensions">Dimensions</label></td><td><textarea id="dimensions" name="dimensions" placeholder="Dimensions" ></textarea></td></tr>
<tr><td><label for="paper_stock">Paper stock</label></td><td><textarea id="paper_stock" name="paper_stock" placeholder="Paper stock"></textarea></td></tr>
<tr><td><label for="binding">Binding</label></td><td><textarea id="binding" name="binding" placeholder="Binding" ></textarea></td></tr>
<tr><td><label for="publishing_format">Publishing format</label></td><td><textarea id="publishing_format" name="publishing_format" placeholder="Publishing format"></textarea></td></tr>
<tr><td><label for="publication_type_id">Publication type</label></td><td><?= getSelectComponent($db, 'series_publication_type'); ?></td></tr>

		
