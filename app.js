/**
 * ファイルの読み込みが完了したら実行
 **/
window.onload = ()=>{
  //-------------------------------------
  // get.phpと通信を行う
  //-------------------------------------
  fetch("get.php")
    // get.phpから返却された値をJavaScriptから操作できるよう加工する
    .then((res)=>{
      return( res.json() );
    })
    // 加工した値を使って処理する
    .then((json)=>{
      if( json["status"] ){
        const count = document.querySelector("#count");  // id="count"とある箇所のHTMLを取得
        count.innerHTML = json['count'];  // get.phpから取得した値をセットする
      }
      else{
        alert("APIでエラーが発生しました");
      }
    })
    // 通信中などにエラーが発生した場合は↓ここが実行される
    .catch((error)=>{
        alert("通信中にエラーが発生しました");
    });
}

/**
 * 再読み込みボタンがクリックされたら実行
 **/
document.querySelector("#btn-reload").addEventListener("click", ()=>{
  // 現在のページを再読み込みする
  location.reload();
});

