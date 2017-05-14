
<tr><td><label for="title">Title</label></td><td><input type="text" id="title" name="title" placeholder="Title" required="required" maxlength="255"  /></td></tr>
<tr><td><label for="issue_id">Issue ID</label></td><td><input type="text" id="issue_id" name="issue_id" placeholder="Issue ID" maxlength="11" /></td></tr>
<tr><td><label for="features">Features</label></td><td><textarea type="text" id="features" name="features" placeholder="Feature 1, Feature 2, ..."></textarea></td></tr>
<tr><td><label for="characters">Characters</label></td><td><textarea type="text" id="characters" name="characters" placeholder="Character 1, Character 2, ..."></textarea></td></tr>
<tr><td><label for="script">Script</label></td><td><textarea type="text" id="script" name="script" placeholder="Script" maxlength="255"></textarea></td></tr>
<tr><td><label for="pencils">Pencils</label></td><td><textarea type="text" id="pencils" name="pencils" placeholder="Pencils" maxlength="255"></textarea></td></tr>
<tr><td><label for="inks">Inks</label></td><td><textarea id="inks" name="inks" placeholder="Ink 1, Ink 2, ..."></textarea></td></tr>
<tr><td><label for="colors">Colors</label></td><td><textarea id="colors" name="colors" placeholder="Colors"></textarea></td></tr>
<tr><td><label for="letters">Letters</label></td><td><textarea id="letters" name="letters" placeholder="letter 1, letter 2, ..."></textarea></td></tr>
<tr><td><label for="editing">Editing</label></td><td><textarea id="editing" name="editing" placeholder="editing 1, editing 2, ..." ></textarea></td></tr>
<tr><td><label for="synopsis">Synopsis</label></td><td><textarea id="synopsis" name="synopsis" placeholder="Synopsis"></textarea></td></tr>
<tr><td><label for="reprint_note">Reprint note</label></td><td><textarea id="reprint_note" name="reprint_note" placeholder="Reprint note" ></textarea></td></tr>
<tr><td><label for="notes">Notes</label></td><td><textarea id="notes" name="notes" placeholder="Notes"></textarea></td></tr>
<tr><td><label for="type_id">Type</label></td><td><?= getSelectComponent($db, 'story_type'); ?></td></tr>
