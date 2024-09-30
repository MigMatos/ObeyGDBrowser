function sanitizerCode(code) {
    // Create a DOMParser object
    var parser = new DOMParser();

    // Parse the code as an HTML document
    var doc = parser.parseFromString(code, 'text/html');

    // Define allowed HTML tags
    var allowedTags = ['DIV','P','SPAN','BR','B', 'I', 'U', 'DISCORD-SPOILER', 'H4', 'H5', 'H6', 'CODE', 'LI', 'A', 'DISCORD-MENTION', 'IMG'];

    // Recursively validate nodes
    function validateNode(node) {
        if (node.nodeType === 1) { // Element node
            if (allowedTags.includes(node.nodeName)) {
                // Allow the node and its attributes
                var allowedNode = document.createElement(node.nodeName);
                Array.from(node.attributes).forEach(function (attribute) {
                    allowedNode.setAttribute(attribute.name, attribute.value);
                });
                // Validate child nodes recursively
                Array.from(node.childNodes).forEach(function (childNode) {
                    allowedNode.appendChild(validateNode(childNode));
                });
                return allowedNode;
            } else {
                // If the tag is not allowed, return a text node with its content
                return document.createTextNode(node.outerHTML);
            }
        } else if (node.nodeType === 3) { // Text node
            return document.createTextNode(node.nodeValue);
        } else {
            // Other node types (comments, etc.)
            return document.createTextNode('');
        }
    }

    // Create a new container element and add allowed nodes
    var safeContainer = document.createElement('span');
    Array.from(doc.body.childNodes).forEach(function (childNode) {
        safeContainer.appendChild(validateNode(childNode));
    });

    // Get the safe HTML content of the container
    var safeHTML = safeContainer.innerHTML;

    return safeHTML;
}