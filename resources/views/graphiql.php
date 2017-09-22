<!DOCTYPE html>
<html>
<head>
    <title>GraphiQL</title>
    <link rel="stylesheet" href="//unpkg.com/normalize.css"/>
    <link rel="stylesheet" href="//unpkg.com/graphiql@^0.9.3/graphiql.css"/>
</head>
<body>
<div id="graphiql" style="height: 100vh;"></div>
<script src="//unpkg.com/whatwg-fetch@0.11.1/fetch.js"></script>
<script src="//unpkg.com/react@^15.0/dist/react.min.js"></script>
<script src="//unpkg.com/react-dom@^15.0/dist/react-dom.min.js"></script>
<script src="//unpkg.com/graphiql@^0.9.3/graphiql.js"></script>
<script>
    function graphQLFetcher(graphQLParams) {
        return fetch('/graphql', {
            method: 'post',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(graphQLParams)
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (responseBody) {
                try {
                    return JSON.parse(responseBody);
                } catch (error) {
                    return responseBody;
                }
            });
    }

    ReactDOM.render(
        React.createElement(GraphiQL, {fetcher: graphQLFetcher}),
        document.getElementById('graphiql')
    );
</script>
</body>
</html>
