async function fetchGithubVersion(owner, repo, branchType, currentVersion, currentDate) {

    const isNewerThan = (date1, date2) => date1 > date2;
    const toUnixTimestamp = iso => isNaN(new Date(iso).getTime()) ? 0 : Math.floor(new Date(iso).getTime() / 1000);

    try {
		// console.log(currentDate);
		
        if (currentVersion === null || currentDate === null) {
            console.error("Error getting actually version and binaryversion...");
            return {currentVersion: 0};
        } 

        const cacheDuration = 10 * 60 * 1000; // 10 minutes in ml
        function isCacheValid(cacheTime) { return (new Date().getTime() - cacheTime) < cacheDuration;}

        // ------------ MAIN ------------
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
                masterData.tag_name = masterData.commit.sha.substring(0, 7) + "-MAIN"; 
                masterData.zipball_url = `https://codeload.github.com/${owner}/${repo}/zip/main`;
                masterData.body = masterData.commit.commit.message;
                masterData.version_date = toUnixTimestamp(masterData.commit.commit.committer.date);
                localStorage.setItem('branchMasterCache', JSON.stringify(masterData));
                localStorage.setItem('branchMasterCacheTime', new Date().getTime().toString());
            }

            const latestDate = masterData.version_date;
            console.log("Converted date to:", latestDate);
            if (isNewerThan(latestDate, currentDate)) {
                return {
                    type: 'master',
                    currentVersion: currentVersion,
                    data: masterData
                };
            } else {
                return {currentVersion: currentVersion, updated: true};
            }
        // ------------ LATEST ------------
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
                latestData.version_date = toUnixTimestamp(latestData.created_at);
                localStorage.setItem('branchLatestCache', JSON.stringify(latestData));
                localStorage.setItem('branchLatestCacheTime', new Date().getTime().toString());
            }

            const latestVersion = latestData.tag_name;
            const latestDate = latestData.version_date;
            console.log("Converted date to:", latestDate);
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
        // ------------ BETA / ALPHA ------------
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
                prereleaseData = releases.find(release => release.prerelease && isNewerThan(toUnixTimestamp(release.created_at), currentDate));
                if (prereleaseData) {
                    prereleaseData.version_date = toUnixTimestamp(prereleaseData.created_at);
                    localStorage.setItem('branchPrereleaseCache', JSON.stringify(prereleaseData));
                    localStorage.setItem('branchPrereleaseCacheTime', new Date().getTime().toString());
                }
            }

            if (prereleaseData) {
                const prereleaseVersion = prereleaseData.tag_name;
                const prereleaseDate = prereleaseData.version_date;
                console.log("Converted date to:", prereleaseDate);
                // const prereleaseDate = new Date(prereleaseData.created_at);
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