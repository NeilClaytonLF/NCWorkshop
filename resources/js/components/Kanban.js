import React from 'react';
import ReactDOM from 'react-dom';
import {Container} from "postcss";
import {DragDropContext, Droppable, Draggable} from "react-beautiful-dnd";
import axios from "axios";

class Task extends React.Component
{
    render()
    {
        return(
            <Draggable draggableId={this.props.task.id} index={this.props.index}>
                {(provided, snapshot) => (
                    <Container
                        {...provided.draggableProps}
                        {...provided.dragHandleProps}
                        innerRef={provided.innerRef}
                        isDragging={snapshot.isDragging}
                    >
                        {this.props.task.content}
                    </Container>
                )};
            </Draggable>
        )
    }
}

class Column extends React.Component
{
    render()
    {
        return (
            <Container>
                <Title>{this.props.column.title}</Title>
                <Draggable droppableId={this.props.column.id}>
                    {(provided, snapshot) => (
                        <TaskList
                            innerRef={provided.innerRef}
                            {...provided.droppableProps}
                            isDraggingOver={snapshot.isDraggingOver} //use to add style when task is being dragged over column
                        >
                            {this.props.tasks.map((task, index) => (
                                <Task key={task.id} task={task} index={index}/>
                            ))}
                            {provided.placeholder}
                        </TaskList>
                    )}
                </Draggable>
            </Container>
        );
    }
}

class Kanban extends React.Component
{
    state = initialData;
    onDragEnd = result => {
        const { destination, source, draggableId} = result;

        // has the task been dragged into a droppable location
        // if not just return
        if(!destination) {
            return;
        }
        // has the task changed position after the drag event finished
        // if not just return
        if (
            destination.droppableId === source.droppableId &&
            destination.index === source.index
        ) {
            return;
        }

        const start = this.state.columns[source.droppableId];
        const finish = this.state.columns[destination.droppableId];
        const newTaskIds = Array.from(column.taskIds)
        newTaskIds.splice(source.index, 1);
        newTaskIds.splice(destination.index, 0, draggableId)

        if(fromColumn === toColumn) {
            //TODO: preserve column tasks index orders
            const newColumn = {
                ...column,
                newTaskIds: newTaskIds,
            }

            const newState = {
                ...this.state,
                columns: {
                    ...this.state.columns,
                    [newColumn.id]: newColumn,
                }
            }
            this.setState(newState);
            return
        }

        //TODO: store state changes as tasks move between columns
        const startTaskIds = Array.from(start.taskIds)
        startTaskIds.splice(source.index, 1);
        const newStart = {
            ...start,
            taskIds: startTaskIds
        }

        const finishTaskIds = Array.from(finish.taskIds)
        finishTaskIds.splice(destination.index, 0, draggableId);
        const newFinish = {
            ...finish,
            taskIds: finishTaskIds,
        }

        const newState = {
            ...this.state,
            columns: {
                ...this.state.columns.columns,
                [newStart.id]: newStart,
                [newFinish.id]: newFinish
            }
        }
        this.setState(newState)
    }
    render() {
        return(
            <DragDropContext onDragEnd={this.onDragEnd}>
                <Container>
                    {this.state.columnOrder.map(columnId => {
                        const column = this.state.columns[columnId];
                        const tasks = column.tasksId.map(taskId => this.state.tasjs[taskId]);
                        return <Column key={column.id} column={column} tasks={tasks} />;
                    })};
                </Container>
            </DragDropContext>
        );
    }

}

if (document.getElementById('kanban')) {
    ReactDOM.render(<Kanban />, document.getElementById('kanban'));
}
