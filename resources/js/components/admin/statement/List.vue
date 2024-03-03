<template>
  <div class="container dashboard">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h2>Statement of Account</h2>
          </div>
          <div class="card-body d-grid gap-3">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead class="table__head">
                  <tr class="winner__table">
                    <th>#</th>
                    <th><i class="fa fa-book" aria-hidden="true"></i> Date</th>
                    <th>
                      <i class="fa fa-money" aria-hidden="true"></i> Amount
                    </th>
                    <th>
                      <i class="fa fa-bank" aria-hidden="true"></i> Type
                    </th>
                    <th>
                      <i class="fa fa-barcode" aria-hidden="true"></i> Desc
                    </th>
                    <th>
                      <i class="fa fa-money" aria-hidden="true"></i>
                      Balance
                    </th>
                  </tr>
                </thead>
                <tbody v-if="transactions.data && transactions.data.length > 0">
                  <tr
                    v-for="transaction in transactions.data"
                    :key="transaction.id"
                    class="winner__table"
                  >
                    <td>{{ transaction.id }}</td>
                    <td>{{ transaction.created_date }}</td>
                    <td>{{ transaction.amount }}</td>
                    <td>{{ accountType(transaction) }}</td>
                    <td>{{ accountDesc(transaction) }}</td>
                    <td>{{ accountBal(transaction) }}</td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">No record found.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <Bootstrap5Pagination
              class="mb-0"
              :data="transactions"
              :limit="limit"
              :keep-length="keepLength"
              :show-disabled="showDisabled"
              :size="size"
              :align="align"
              @pagination-change-page="getResults"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import 'bootstrap/dist/css/bootstrap.css';
import { Bootstrap5Pagination } from 'laravel-vue-pagination/src/lib';
export default {
  name:"transactions",
  components:{
    Bootstrap5Pagination
  },
  data(){
      return {
        processing:false,
        transactions: [],
        limit: 10,
        keepLength: false,
        showDisabled: false,
        size: 'default',
        align: 'left',
        term: '',
        user:this.$store.state.auth.user
      }
  },
  mounted() {
    this.getStatement(1)
  },
  methods: {
    async getStatement(page){
        this.processing = true
        await axios.get('/sanctum/csrf-cookie')
        await axios.get(`/api/account/statement?page=${page}`).then(({data})=>{
            this.transactions = data.data
        }).catch(({response})=>{

        }).finally(()=>{
            this.processing = false
        })
    },
    getResults(page){
      if (!page) {
        page = 1;
      }
      this.getStatement(page)
    },
    search(){
      this.getStatement(1)
    },
    accountType(data){
      if (data.type === 'Transfer') {
        if (data.receiver_id == this.user.id) {
          return 'Credit'
        } else {
          return 'Debit'
        }
      }
      return data.type
    },
    accountDesc(data){
      if (data.type === 'Transfer') {
        if (data.receiver_id == this.user.id) {
          return 'Received Money'
        } else {
          return data.description
        }
      }
      return data.description
    },
    accountBal(data){
      if (data.type === 'Transfer') {
        if (data.receiver_id == this.user.id) {
          return '-'
        } else {
          return data.balance
        }
      }
      return data.balance
    }
  }
}
</script>

<style scoped>
.table__head {
  color: #fff;
  font-weight: 700;
  background: #9b4085;
  background: -moz-linear-gradient(-45deg, #9b4085 0%, #608590 100%);
  background: -webkit-linear-gradient(-45deg, #9b4085 0%, #608590 100%);
  background: linear-gradient(135deg, #9b4085 0%, #608590 100%);
  white-space: nowrap;
}
.table-bordered td,
.table-bordered th {
  border: 0px solid #fff;
}
.winner__table {
  white-space: nowrap;
}

@media screen and (max-width: 567px) {
  .winner__table {
    font-size: 12px;
  }
}
</style>
