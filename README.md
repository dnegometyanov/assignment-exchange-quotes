# Assignment quotes retriever

Test assignment implementation for php api that retrieves quotes from third party api,
displays them in the table and chart and sends used notification.

## Key implementation notes

**Basic idea of this implementation is asynchronous architecture,
so that slow and failure-risky third party services for quotes
do not slow down the user interface**
