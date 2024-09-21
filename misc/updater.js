async function fetchGithubVersion(owner, repo, branchType, versionFile) {
    async function getCurrentVersionAndDate() {
        try {
            const response = await fetch(versionFile);
            const text = await response.text();
            const [version, date] = text.trim().split('|').map(part => part.trim());
            return { version: version.trim(), date: date ? new Date(date.trim()) : new Date(0) };
        } catch (error) {
            console.error("Error reading version.txt:", error);
            return { version: null, date: new Date(0) };
        }
    }

    const isNewerThan = (date1, date2) => date1 > date2;

    try {
        const { version: currentVersion, date: currentDate } = await getCurrentVersionAndDate();

		console.log(currentDate);
		
        if (currentVersion === null || currentDate === null) {
            console.error("No se pudo obtener la versión actual o la fecha.");
            return {currentVersion: 0};
        } 

        const cacheDuration = 10 * 60 * 1000; // 10 minutos en milisegundos

        function isCacheValid(cacheTime) {
            return (new Date().getTime() - cacheTime) < cacheDuration;
        }

        if (branchType === 'master') {
            let masterCache = localStorage.getItem('branchMasterCache');
            let cacheTime = localStorage.getItem('branchMasterCacheTime');
            let masterData;

            if (masterCache && cacheTime && isCacheValid(parseInt(cacheTime))) {
                console.log("Using cached info from master branch");
                masterData = JSON.parse(masterCache);
            } else {
                const masterResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/branches/main`);
                masterData = await masterResponse.json();
                masterData.tag_name = masterData.commit.sha.substring(0, 10) + "-main"; 
                masterData.zipball_url = `https://codeload.github.com/${owner}/${repo}/zip/main`;
                masterData.body = null;
                localStorage.setItem('branchMasterCache', JSON.stringify(masterData));
                localStorage.setItem('branchMasterCacheTime', new Date().getTime().toString());
            }

            const latestDate = new Date(masterData.commit.commit.committer.date);
            if (isNewerThan(latestDate, currentDate)){
                masterData.version_date = latestDate.toISOString();
                return {
                    type: 'master',
                    currentVersion: currentVersion,
                    data: masterData
                };
            } else {
                return {currentVersion: currentVersion, updated: true};
            }

        } else if (branchType === 'latest') {
            let latestCache = localStorage.getItem('branchLatestCache');
            let cacheTime = localStorage.getItem('branchLatestCacheTime');
            let latestData;

            if (latestCache && cacheTime && isCacheValid(parseInt(cacheTime))) {
                console.log("Using cached info from latest branch");
                latestData = JSON.parse(latestCache);
            } else {
                const latestResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/releases/latest`);
                latestData = await latestResponse.json();
                localStorage.setItem('branchLatestCache', JSON.stringify(latestData));
                localStorage.setItem('branchLatestCacheTime', new Date().getTime().toString());
            }

            const latestVersion = latestData.tag_name;
            const latestDate = new Date(latestData.created_at);
            latestData.zipball_url = `https://codeload.github.com/${owner}/${repo}/zip/refs/tags/${latestVersion}`;

            if (latestVersion !== currentVersion || isNewerThan(latestDate, currentDate)) {
                return {
                    type: 'latest',
                    currentVersion: currentVersion,
                    data: latestData
                };
            } else {
                return {currentVersion: currentVersion, updated: true};
            }

        } else if (branchType === 'prerelease') {
            let prereleaseCache = localStorage.getItem('branchPrereleaseCache');
            let cacheTime = localStorage.getItem('branchPrereleaseCacheTime');
            let prereleaseData;

            if (prereleaseCache && cacheTime && isCacheValid(parseInt(cacheTime))) {
                console.log("Using cached info from pre-release branch");
                prereleaseData = JSON.parse(prereleaseCache);
            } else {
                const releaseResponse = await fetch(`https://api.github.com/repos/${owner}/${repo}/releases`);
                const releases = await releaseResponse.json();
                prereleaseData = releases.find(release => 
                    release.prerelease && 
                    (release.tag_name.replace(/^v/, '') !== currentVersion || 
                    isNewerThan(new Date(release.created_at), currentDate))
                );
                if (prereleaseData) {
                    localStorage.setItem('branchPrereleaseCache', JSON.stringify(prereleaseData));
                    localStorage.setItem('branchPrereleaseCacheTime', new Date().getTime().toString());
                }
            }

            if (prereleaseData) {
                const prereleaseVersion = prereleaseData.tag_name;
                const prereleaseDate = new Date(prereleaseData.created_at);
                prereleaseData.zipball_url = `https://codeload.github.com/${owner}/${repo}/zip/refs/tags/${prereleaseVersion}`;
                return {
                    type: 'prerelease',
                    currentVersion: currentVersion,
                    data: prereleaseData
                };
            } else {
                return {currentVersion: currentVersion, updated: true};
            }
        }
    } catch (error) {
        console.error("Error fetching version from GitHub:", error);
        return {currentVersion: 0};
    }
}