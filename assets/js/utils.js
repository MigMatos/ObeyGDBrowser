function processHTMLContent(content){
    console.log("Warning use securityParser::sanitizerCode() for processHTMLContent().")
    replacedContent = customWidgets(content);
    // console.log(replacedContent);
    var replacedContent = replacedContent
    .replace(/\*\*([^*]+)\*\*/g, function (match, p1) {
        return '<b>' + p1 + '</b>';
    })
    .replace(/_([^_]+)_|\*([^*]+)\*/g, function (match, p1, p2) {
        return '<i>' + (p1 || p2) + '</i>';
    })
    .replace(/~([^~]+)~/g, function (match, p1) {
        return '<u>' + p1 + '</u>';
    })
    .replace(/\|\|([^|]+)\|\|/g, function (match, p1) {
        return '<discord-spoiler>' + p1 + '</discord-spoiler>';
    })
    .replace(/(?:\n|\r|^)### (.+)/g, function (match, p1) {
    return '<h6>' + p1 + '</h6>';
	})
	.replace(/(?:\n|\r|^)## (.+)/g, function (match, p1) {
		return '<h5>' + p1 + '</h5>';
	})
	.replace(/(?:\n|\r|^)# (.+)/g, function (match, p1) {
		return '<h4>' + p1 + '</h4>';
	})
    .replace(/`([^`]+)`/g, function (match, p1) {
        var classToUse = 'codeFormat';
        var matchSubclass = p1.match(/[a-z]\d+/);
        if (matchSubclass) {
            classToUse += ' ' + matchSubclass[0];
            p1 = p1.slice(matchSubclass[0].length);
        } else {classToUse += ' default';}
        return '<code class="' + classToUse + '">' + p1 + '</code>';
    })
    .replace(/(?:\n|\r|^)\* (.+)/g, function (match, p1) {
    return '<li>' + p1 + '</li>';
	})
	.replace(/(?:\n|\r|^)\- (.+)/g, function (match, p1) {
		return '<li>' + p1 + '</li>';
	})
    .replace(/\[([^\]]+)\]\(([^)]+)\)/g, function (match, p1, p2) {
        return '<a href="' + p2 + '">' + p1 + '</a>';
    })
    .replace(/<@(\d+)>/g, function (match, p1) {
        return '<discord-mention type="user" user-id="' + p1 + '"></discord-mention>';
    })
    .replace(/<@&(\d+)>/g, function (match, p1) {
        return '<discord-mention type="role" role-id="' + p1 + '"></discord-mention>';
    })
    .replace(/<#(\d+)>/g, function (match, p1) {
        return '<discord-mention type="channel" channel-id="' + p1 + '"></discord-mention>';
    })
    .replace(/\n/g, '<br>');
    return processEmojis(replacedContent);
}

function processEmojis(content) {
    var emojiRegex = /<(a?):([^:]+):(\d+)>/g;

    content = content.replace(emojiRegex, function(match, animated, name, id) {
        var extension = animated ? 'gif' : 'webp';
        return '<img class="discordEmoji" src="https://cdn.discordapp.com/emojis/' + id + '.' + extension + '?size=80&quality=lossless" alt=":' + name + ':">';
    });

    return content;
}

function customWidgets(content) {
    widgetLink = content.replace(/\[!\[(.*?)\]\((.*?)\)\]\((.*?)\)/, "<a href='$3' target='_blank' class='utils-customWidget'><img src='$2' alt='$1'></a>");
    return widgetLink;
}

const base64Decode = (encodedData) => {
    return atob(encodedData);
}

const strtr = (str, from, to) => {
    const map = {};
    for (let i = 0; i < from.length; i++) {
      map[from.charAt(i)] = to.charAt(i);
    }
    return str.replace(/./g, (c) => {
      return map[c] || c;
    });
}