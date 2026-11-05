(function () {
    'use strict';

    const versionFields = document.getElementById('gameVersionSettings');
    if (versionFields) {
        const catalog = JSON.parse(document.getElementById('gameVersionCatalog').textContent);
        const gameChoice = document.getElementById('gdpsVersionChoice');
        const binaryChoice = document.getElementById('gdpsBinaryChoice');
        const gameValue = document.getElementById('gdps_version');
        const binaryValue = document.getElementById('gdps_binary_version');
        const releaseValue = document.getElementById('gdps_game_release');
        const customGame = document.getElementById('gdpsCustomVersion');
        const customBinary = document.getElementById('gdpsCustomBinary');

        function getReleases() {
            const protocol = gameChoice.value === 'custom' ? customGame.value : gameChoice.value;
            return catalog[protocol]?.releases || [];
        }

        function synchronizeValues() {
            const releases = getReleases();
            gameValue.value = gameChoice.value === 'custom' ? customGame.value : gameChoice.value;
            if (binaryChoice.value === 'latest') {
                binaryValue.value = String(Math.max(0, ...releases.map(release => release.binaryVersion)));
            } else {
                binaryValue.value = binaryChoice.value === 'custom' ? customBinary.value : binaryChoice.value;
            }
            const previousRelease = releaseValue.value;
            releaseValue.value = '';
            if (gameChoice.value !== 'custom' && binaryChoice.value !== 'custom') {
                const matches = releases.filter(release => String(release.binaryVersion) === binaryValue.value);
                const selected = binaryChoice.value === 'latest' ? matches.at(-1) : matches.find(release => release.version === previousRelease) || matches.at(-1);
                if (selected) {
                    releaseValue.value = selected.version;
                }
            }
            const customGameSelected = gameChoice.value === 'custom';
            const customBinarySelected = binaryChoice.value === 'custom';
            document.getElementById('customGameVersionField').hidden = !customGameSelected;
            document.getElementById('customBinaryVersionField').hidden = !customBinarySelected;
            customGame.disabled = !customGameSelected;
            customGame.required = customGameSelected;
            customBinary.disabled = !customBinarySelected;
            customBinary.required = customBinarySelected;
            const label = catalog[gameValue.value]?.label || 'Custom';
            document.getElementById('gameVersionSummary').textContent = binaryValue.value === '0'
                ? `Game ${label}: binary restrictions disabled (0).`
                : `Game ${label}: binary ${binaryValue.value}${releaseValue.value ? ` — ${releaseValue.value}` : ' (custom)'}.`;
        }

        function rebuildBinaries(mode, initial = false) {
            const releases = getReleases();
            const grouped = new Map();
            for (const release of releases) {
                if (release.binaryVersion > 0) {
                    const key = String(release.binaryVersion);
                    if (!grouped.has(key)) {
                        grouped.set(key, []);
                    }
                    grouped.get(key).push(release.version);
                }
            }
            const latest = Math.max(0, ...Array.from(grouped.keys(), Number));
            binaryChoice.replaceChildren(new Option('Disabled / unspecified (0)', '0'));
            const automatic = new Option(latest ? `Automatic — latest known (binary ${latest})` : 'Automatic — no verified binary available', 'latest');
            automatic.disabled = latest === 0;
            binaryChoice.append(automatic);
            for (const [binary, names] of grouped) {
                binaryChoice.append(new Option(`${names.join(' / ')} (binary ${binary})`, binary));
            }
            binaryChoice.append(new Option('Custom', 'custom'));
            if (mode === '0' || mode === 'custom' || grouped.has(mode)) {
                binaryChoice.value = mode;
            } else if (initial) {
                binaryChoice.value = 'custom';
            } else {
                binaryChoice.value = latest > 0 ? 'latest' : '0';
            }
            if (mode === 'latest') {
                binaryChoice.value = latest > 0 ? 'latest' : '0';
            }
            synchronizeValues();
        }

        gameChoice.addEventListener('change', function () {
            rebuildBinaries(binaryChoice.value);
        });
        customGame.addEventListener('input', function () {
            rebuildBinaries(binaryChoice.value);
        });
        binaryChoice.addEventListener('change', function () {
            if (binaryChoice.value === 'custom') {
                customBinary.value = Number(binaryValue.value) > 0 ? binaryValue.value : '1';
            }
            synchronizeValues();
        });
        customBinary.addEventListener('input', synchronizeValues);
        rebuildBinaries(binaryValue.value, true);
    }

    const previewButton = document.getElementById('previewSavedEmojis');
    if (previewButton) {
        previewButton.addEventListener('click', async function () {
            const status = document.getElementById('savedEmojiStatus');
            const preview = document.getElementById('savedEmojiPreview');
            previewButton.disabled = true;
            status.textContent = 'Loading saved emoji configuration…';
            preview.setAttribute('aria-busy', 'true');
            try {
                GDEmojis.clearCache();
                const config = await GDEmojis.getConfig();
                await GDEmojis.renderInto(preview, document.getElementById('savedEmojiMessage').value, {enabled: true});
                status.textContent = `Saved binary: ${config.binaryVersion || 'disabled (0)'}. ${config.binaryVersion >= 51 ? 'Atlas preview only; live comment rendering remains disabled.' : 'Shortcode images require binary 51 or later.'}`;
            } catch (error) {
                preview.replaceChildren();
                status.textContent = 'The saved emoji configuration could not be loaded. Check the saved settings and local atlas files.';
            } finally {
                previewButton.disabled = false;
                preview.setAttribute('aria-busy', 'false');
            }
        });
    }
})();
