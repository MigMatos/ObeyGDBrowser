function escapeHTMLContent(str) {
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;/');
  }
  

function escapeHTMLAttr(str) {
    return str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
}
  
function processHTMLtoMarkdown(content) {
    let output = escapeHTMLContent(content);

    // Custom inline code with `a0`, `b1`, etc.
    output = output.replace(/`([a-z]\d)\s(.*?)`/g,
        (_, cls, text) => `<code class="codeFormat ${cls}">${escapeHTMLContent(text)}</code>`);
  
    // Headings
    output = output.replace(/^###### (.*)$/gim, '<h6>$1</h6>');
    output = output.replace(/^##### (.*)$/gim, '<h5>$1</h5>');
    output = output.replace(/^#### (.*)$/gim, '<h4>$1</h4>');
    output = output.replace(/^### (.*)$/gim, '<h3>$1</h3>');
    output = output.replace(/^## (.*)$/gim, '<h2>$1</h2>');
    output = output.replace(/^# (.*)$/gim, '<h1>$1</h1>');
  
    // Blockquotes
    output = output.replace(/^> (.*)$/gim, '<blockquote>$1</blockquote>');
  
    // Unordered lists
    output = output.replace(/^(\s*[-*+] .*)$/gim, '<ul>$1</ul>');
    output = output.replace(/<ul>(.*?)<\/ul>/gs,
        (_, items) => `${items.replace(/^[-*+] (.*)$/gm, '<li>$1</li>')}`);

    // Ordered lists
    output = output.replace(/^(\s*\d+\. .*)$/gim, '<ol>$1</ol>');
    output = output.replace(/<ol>(.*?)<\/ol>/gs,
        (_, items) => `${items.replace(/^\d+\. (.*)$/gm, '<li>$1</li>')}`);
  
    // Text formatting
    output = output.replace(/\*\*(.*?)\*\*/g, (_, t) => `<strong>${escapeHTMLContent(t)}</strong>`);
    output = output.replace(/__(.*?)__/g, (_, t) => `<u>${escapeHTMLContent(t)}</u>`);
    output = output.replace(/~~(.*?)~~/g, (_, t) => `<del>${escapeHTMLContent(t)}</del>`);
    output = output.replace(/\*(.*?)\*/g, (_, t) => `<em>${escapeHTMLContent(t)}</em>`);
    output = output.replace(/_(.*?)_/g, (_, t) => `<i>${escapeHTMLContent(t)}</i>`);
  
    // Images inside links: [![alt](img)](link)
    output = output.replace(/\[!\[([^\]]*)\]\((https?:\/\/[^\s)]+)\)\]\((https?:\/\/[^\s)]+)\)/g,
    '<a href="$3" class="utils-customWidget" target="_blank" rel="noopener noreferrer"><img src="$2" alt="$1"></a>');

    // Standalone images: ![alt](img)
    output = output.replace(/!\[([^\]]*)\]\((https?:\/\/[^\s)]+)\)/g,
    '<img class="utils-imgWidget" src="$2" alt="$1">');

    // Regular links: [text](url)
    output = output.replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/g,
    '<a class="utils-URL"  href="$2" target="_blank" rel="noopener noreferrer">$1</a>');

    // Convert plain URLs into clickable links
    output = output.replace(/(?<!["'=\]>])\b(https?:\/\/[^\s<>()"]+)/g, (match) => {
        return `<a class="utils-URL plain" href="${match}" target="_blank" rel="noopener noreferrer">${match}</a>`;
    });
  
    // Custom inline color with hex and transparency 
    output = output.replace(/´hex#([0-9a-fA-F]{8}) (.+?)´/g, (_, hex, text) => {
        return `<span style="color:#${hex}">${escapeHTMLContent(text)}</span>`;
    });

    // Custom inline code with class a0, b1, etc.
    output = output.replace(/´([a-z]\d) (.+?)´/g, (_, cls, text) => {
        return `<span class="codeFormat ${cls}">${escapeHTMLContent(text)}</span>`;
    });

    // Hex color codes
    output = output.replace(/`hex#([0-9a-fA-F]{8})\s(.*?)`/g,
        (_, hex, text) => `<code class="codeFormat" style="color:#${hex}">${escapeHTMLContent(text)}</code>`);
  
    // Regular inline code
    output = output.replace(/`([^`]+)`/g,
        (_, text) => `<code class="codeFormat">${escapeHTMLContent(text)}</code>`);

    // Discord mentions
    output = output.replace(/&lt;@&(\d+)&gt;/g, '<discord-mention type="role" role-id="$1"></discord-mention>');
    output = output.replace(/&lt;@(\d+)&gt;/g, '<discord-mention type="user" user-id="$1"></discord-mention>');
    output = output.replace(/&lt;#(\d+)&gt;/g, '<discord-mention type="channel" channel-id="$1"></discord-mention>');

    // Discord emojis
    output = output.replace(/&lt;a:([a-zA-Z0-9_]+):(\d+)&gt;/g,
        (_, name, id) => `<img class="discordEmoji" src="https://cdn.discordapp.com/emojis/${escapeHTMLAttr(id)}.gif?size=80&quality=lossless" alt="${escapeHTMLAttr(name)}">`);
    output = output.replace(/&lt;([a-zA-Z0-9_]+):(\d+)&gt;/g,
        (_, name, id) => `<img class="discordEmoji" src="https://cdn.discordapp.com/emojis/${escapeHTMLAttr(id)}.webp?size=80&quality=lossless" alt="${escapeHTMLAttr(name)}">`);

    // Spoilers
    output = output.replace(/\|\|(.+?)\|\|/g, '<discord-spoiler>$1</discord-spoiler>');
    

    // Code blocks
    output = output.replace(/```([\s\S]*?)```/g, (_, code) => {
        return `<pre><code>${escapeHTMLContent(code)}</code></pre>`;
    });

    const blockTags = /<\/?(h\d|ul|ol|li|pre|code|blockquote|a|img|discord-mention|discord-spoiler|strong|i|u|em|del)[^>]*>/i;
    output = output
        .split(/\n{2,}/)
        .map(par => blockTags.test(par) ? par : `<p>${par}</p>`)
        .join('\n');
    output = output.replace(/\r\n\r\n/g, '<br><br>').replace(/(?<!\r)\n/g, '<br>');         
    

      
    return output;
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