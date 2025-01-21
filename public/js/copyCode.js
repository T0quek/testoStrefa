function CopyToClipboard(selector) {
    const element = document.querySelector(selector);
    if (!element) return;

    const textToCopy = element.innerText || element.value;
    if (!textToCopy) return;

    if (navigator.clipboard?.writeText) {
        navigator.clipboard.writeText(textToCopy).catch(console.error);
    } else {
        const tempTextarea = document.createElement("textarea");
        tempTextarea.value = textToCopy;
        document.body.appendChild(tempTextarea);
        tempTextarea.select();
        document.execCommand("copy");
        document.body.removeChild(tempTextarea);
    }
}
