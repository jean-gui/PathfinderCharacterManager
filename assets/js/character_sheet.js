function notify(message) {
    if (("Notification" in window) && Notification.permission === "granted") {
        var notification = new Notification(message);
    }
}

fetch('/en/hub-url')
    .then(response => {
        const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1];
        const hub = new URL(hubUrl);

        const characters = document.querySelectorAll("h1[data-character-id]");
        characters.forEach(function (character) {
            hub.searchParams.append('topic', 'https://pathfinder.troulite.fr/characters/' + character.dataset.characterId);
        });

        const eventSource = new EventSource(hub);

        eventSource.onmessage = event => {
            const data = JSON.parse(event.data);
            notify(data['message']);
            document.location.reload(true);
        }
    });
