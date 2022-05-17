import React from 'react';
import ReactDOM from 'react-dom';

export default function Kanban() {
    return (
        <h1>Kanban Section</h1>
    );
}

if (document.getElementById('kanban')) {
    ReactDOM.render(<Kanban />, document.getElementById('kanban'));
}