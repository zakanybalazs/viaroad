//external imports
const expect = require('expect');
const supertest = require('supertest');
//internal imports
const {app} = require('./../server');
const {Todo} = require('./../models/todo');
const {User} = require('./../models/user');

beforeEach((done) => {
  Todo.remove({}).then(() => {
    done();
  });
});

describe('POST /todos', () => {
  it('should create a new todo', (done) => {
    var text = 'test todo text';

    supertest(app)
      .post('/todos')
      .send({
        text
      })
      .expect(200)
      .expect( (res) => {
        expect(res.body.text).toBe(text);
      })
      .end((err,res) => {
        if (err){
          return done(err);
        }

        Todo.find().then((todos) => {
          expect(todos.length).toBe(1);
          expect(todos[0].text).toBe(text);
          done();
        }).catch((err) => done(err));
      });
  });
  it('should not create with invalid body data', (done) => {
    var text = ''; //empty so shouldnt take it

    supertest(app)
      .post('/todos')
      .send({
        text
      })
      .expect(400)
      .expect( (res) => {
        expect(res.body.text).toBe(undefined);
      })
      .end((err,res) => {
        if (err){
          return done(err);
        }

        Todo.find().then((todos) => {
          expect(todos.length).toBe(0);
          // expect(todos[0].text).toBe(text);
          done();
        }).catch((err) => done(err));
      });
  });
});
