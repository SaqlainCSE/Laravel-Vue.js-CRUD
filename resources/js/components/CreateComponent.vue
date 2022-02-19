<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Create New Student</div>

                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="name" id="name" placeholder="Enter Name">
                            </div><br>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" v-model="email" id="email" aria-describedby="email" placeholder="Enter Email">
                            </div><br>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" v-model="phone" id="phone" placeholder="Enter Phone Number">
                            </div><br>

                            <button @click.prevent="saveStudent" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div><br>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">All Students</div>

                    <div class="card-body">
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student,index) in students.data" :key="student.id">
                            <th scope="row">{{index+1}}</th>
                            <td>{{ student.name }}</td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.phone }}</td>
                            <td>
                                <button type="button" @click="editStudent(student.id)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
                                <button type="button" @click="deleteStudent(student.id)" class="btn btn-danger">Delete</button>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                        <pagination :data="students" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                            <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="editname" id="name" placeholder="Enter Name">
                            </div><br>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" v-model="editemail" id="email" aria-describedby="email" placeholder="Enter Email">
                            </div><br>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" v-model="editphone" id="phone" placeholder="Enter Phone Number">
                            </div><br>

                            <button @click.prevent="updateStudent" class="btn btn-primary" data-bs-dismiss="modal">Update</button>
                        </form>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                students: {},
                id: '',
                name:'',
                email:'',
                phone:'',
                editname: '',
                editemail: '',
                editphone: ''
            }
        },
        mounted() {

            this.getResults();

            console.log('Component mounted.')
        },
        methods: {
            getResults(page = 1) {
			axios.get('all_students?page=' + page)
				.then(response => {
                    console.log(response.data);
					this.students = response.data;
				});
		    },
            saveStudent() {
                axios.post('save_student',{
                    name: this.name,
                    email: this.email,
                    phone: this.phone
                })
                .then(response => {
                    this.name = '';
                    this.email = '';
                    this.phone = '';
                    this.getResults();
                    console.log(response);
                });
            },
            editStudent(id){
                axios.get('edit_student/' + id)
                .then(response => {
                    this.id = response.data.id;
                    this.editname = response.data.name;
                    this.editemail = response.data.email;
                    this.editphone = response.data.phone;
                    // this.getResults();
                });
            },
            updateStudent(){
                axios.put('update_student',{
                    id: this.id,
                    name: this.editname,
                    email: this.editemail,
                    phone: this.editphone
                })
                .then(response => {
                    this.getResults();
                    console.log(response);
                });
            },
            deleteStudent(id) {
                axios.delete('delete_student/' + id)
                .then(response => {
                    this.getResults();
                    console.log(response);
                });
            }
        }
    }
</script>
