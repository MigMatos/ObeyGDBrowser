<?php
if (!isset($gdps_settings) || !is_array($gdps_settings) || !function_exists('getGameVersionGroups')) {
    http_response_code(404);
    exit();
}
$versionGroups = getGameVersionGroups();
$selectedGameVersion = strval(intval($gdps_settings['gdps_version'] ?? 22));
$savedBinaryVersion = $gdps_settings['gdps_binary_version'] ?? 0;
$selectedBinaryVersion = is_scalar($savedBinaryVersion) && preg_match('/^[0-9]+$/D', (string) $savedBinaryVersion) && $savedBinaryVersion <= 100000 ? strval(intval($savedBinaryVersion)) : '0';
$isCustomGameVersion = !isset($versionGroups[$selectedGameVersion]);
$binaryGroups = array();
foreach ($versionGroups[$selectedGameVersion]['releases'] ?? array() as $release) {
    if ($release['binaryVersion'] > 0) {
        $binaryGroups[$release['binaryVersion']][] = $release['version'];
    }
}
$isCustomBinaryVersion = $selectedBinaryVersion !== '0' && !isset($binaryGroups[$selectedBinaryVersion]);
?>
<fieldset id="gameVersionSettings">
    <legend>Game version</legend>
    <input type="hidden" name="gameVersionSettingsSubmitted" value="1">
    <input type="hidden" id="gdps_version" name="gdps_version" value="<?= htmlspecialchars($selectedGameVersion, ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" id="gdps_binary_version" name="gdps_binary_version" value="<?= htmlspecialchars($selectedBinaryVersion, ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" id="gdps_game_release" name="gdps_game_release" value="<?= htmlspecialchars($gdps_settings['gdps_game_release'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
    <label for="gdpsVersionChoice">Game version:</label>
    <select id="gdpsVersionChoice" name="gdpsVersionChoice">
        <?php foreach ($versionGroups as $protocol => $group) { ?>
            <option value="<?= intval($protocol) ?>" <?= $selectedGameVersion === strval($protocol) ? 'selected' : '' ?>><?= htmlspecialchars($group['label'], ENT_QUOTES, 'UTF-8') ?></option>
        <?php } ?>
        <option value="custom" <?= $isCustomGameVersion ? 'selected' : '' ?>>Custom</option>
    </select>
    <div class="version-custom-field" id="customGameVersionField" <?= $isCustomGameVersion ? '' : 'hidden' ?>>
        <label for="gdpsCustomVersion">Custom game protocol code:</label>
        <input type="number" id="gdpsCustomVersion" name="gdpsCustomVersion" min="0" max="100000" value="<?= htmlspecialchars($selectedGameVersion, ENT_QUOTES, 'UTF-8') ?>" <?= $isCustomGameVersion ? 'required' : 'disabled' ?>>
    </div>
    <label for="gdpsBinaryChoice">Game patch / binary version:</label>
    <select id="gdpsBinaryChoice" name="gdpsBinaryChoice">
        <option value="0" <?= $selectedBinaryVersion === '0' ? 'selected' : '' ?>>Disabled / unspecified (0)</option>
        <option value="latest" <?= $binaryGroups ? '' : 'disabled' ?>>Automatic — latest known for this game version</option>
        <?php foreach ($binaryGroups as $binary => $releases) { ?>
            <option value="<?= intval($binary) ?>" <?= $selectedBinaryVersion === strval($binary) ? 'selected' : '' ?>><?= htmlspecialchars(implode(' / ', $releases), ENT_QUOTES, 'UTF-8') ?> (binary <?= intval($binary) ?>)</option>
        <?php } ?>
        <option value="custom" <?= $isCustomBinaryVersion ? 'selected' : '' ?>>Custom</option>
    </select>
    <div class="version-custom-field" id="customBinaryVersionField" <?= $isCustomBinaryVersion ? '' : 'hidden' ?>>
        <label for="gdpsCustomBinary">Custom binary code:</label>
        <input type="number" id="gdpsCustomBinary" name="gdpsCustomBinary" min="1" max="100000" value="<?= htmlspecialchars($selectedBinaryVersion === '0' ? '1' : $selectedBinaryVersion, ENT_QUOTES, 'UTF-8') ?>" <?= $isCustomBinaryVersion ? 'required' : 'disabled' ?>>
    </div>
    <p id="gameVersionSummary" role="status"></p>
    <p>Disabled (0) keeps legacy behavior without binary restrictions. Automatic uses the latest verified entry in the local catalog when you save; opening this form does not upgrade the saved binary.</p>
    <script type="application/json" id="gameVersionCatalog"><?= json_encode($versionGroups, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
</fieldset>
