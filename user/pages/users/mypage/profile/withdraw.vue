<template>
  <div class="page__wrap mypage mypage-withdraw bg-white pb-5">
    <b-container class="p-0">
      <div class="page__content">
        <Sidebar :title="`退会手続き`" :classActive="`withdraw`"/>
        <div class="mypage__right p-35 mt-4">
          <div class="mypage__content">
            <div class="mypage__withdraw">
              <div class="mypage__withdraw-header title-block-line">
                退会手続き
              </div>
              <div class="mypage__notify-text">
                親譲りの無鉄砲で小供の時から損ばかりしている。小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事がある。
                なぜそんな無闇をしたと聞く人があるかも知れぬ。別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、
                いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、
                おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。
                親譲りの無鉄砲で小供の時から損ばかりしている。小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事がある。
                なぜそんな無闇をしたと聞く人があるかも知れぬ。別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、
                いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、
                おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。（青空文庫より）
              </div>
              <div class="form-default form-withdraw mt-5">
                <b-form>
                  <b-form-group label="退会する理由" label-for="withdraw">
                    <b-form-textarea
                      id="withdraw"
                      placeholder="200文字以内でお願い致します"
                      rows="5"
                      max-rows="7"
                    />
                  </b-form-group>
                  <br/>
                  <div class="d-flex flex-column align-items-center flex-md-row">
                    <b-button type="submit" class="btn btn-blue btn-submit m-0 w-148">
                      退会
                    </b-button>
                    <b-link href="/users/mypage/notify" class="btn btn-grey w-148 mt-4 mt-md-0 ml-md-4">キャンセル</b-link>
                  </div>
                </b-form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </b-container>
  </div>
</template>

<script>
  import Sidebar from '~/components/organisms/mypage/sidebar'
  export default {
    layout: 'blank',
    name: "detail",
    components: {
      Sidebar
    }
  }
</script>

<style scoped>

</style>
