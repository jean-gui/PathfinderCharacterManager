fetch('/en/hub-url')
    .then(response => {
        const hubUrl = response.headers.get('Link').match(/<([^>]+)>;\s+rel=(?:mercure|"[^"]*mercure[^"]*")/)[1];

        const hub = new URL(hubUrl);
        hub.searchParams.append('topic', 'https://pathfinder.troulite.fr/characters/{id}');

        const eventSource = new EventSource(hub);

        eventSource.onmessage = event => {
            // Will be called every time an update is published by the server
            document.location.reload(true);
            console.log(JSON.parse(event.data));
        }
    });