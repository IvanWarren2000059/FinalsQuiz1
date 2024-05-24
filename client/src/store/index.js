import { createStore } from "vuex";
import axios from "axios";

export default createStore({
  state: {
    comments: [],
  },
  mutations: {
    updateComment(state, updatedCommentAndComments) {
      const { updatedComment, comments } = updatedCommentAndComments;

      comments.forEach((element) => {
        if (element.id === updatedComment.id) {
          element.comment = updatedComment.comment;
        }
      });
    },

    deleteComment(state, updatedCommentAndComments) {
      const { selectedComment, comments } = updatedCommentAndComments;

      const commentIndex = comments.findIndex(
        (comment) => comment.id === selectedComment.id
      );
      if (commentIndex !== -1) {
        comments.splice(commentIndex, 1);
      }

      console.log(commentIndex);
    },
  },

  actions: {
    saveComment({ commit }, commentAndPostObject) {
      axios
        .put(
          `http://localhost:8000/api/comments/${commentAndPostObject.comment.id}`,
          { comment: commentAndPostObject.comment.editedComment },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              user_id: localStorage.getItem("userId"),
            },
          }
        )
        .then((response) => {
          commit("updateComment", {
            updatedComment: response.data.comment,
            comments: commentAndPostObject.post.comments,
          });
        })
        .catch((error) => {
          console.error("Error saving changes:", error);
        });
    },

    deleteComment({ commit }, commentAndPostObject) {
      axios
        .delete(
          `http://localhost:8000/api/comments/${commentAndPostObject.comment.id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              user_id: localStorage.getItem("userId"),
            },
          }
        )
        .then(() => {
          console.log(commentAndPostObject);
          commit("deleteComment", {
            selectedComment: commentAndPostObject.comment,
            comments: commentAndPostObject.post.comments,
          });
        })
        .catch((error) => {
          console.error("Error saving changes:", error);
        });
    },
  },

  getters: {
    getComments(state) {
      return state.comments;
    },
  },
});
