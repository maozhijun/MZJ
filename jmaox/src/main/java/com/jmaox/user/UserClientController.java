package com.jmaox.user;

import com.jmaox.collect.Collect;
import com.jmaox.common.BaseController;
import com.jmaox.common.Constants;
import com.jmaox.topic.Topic;
import com.jmaox.utils.StrUtil;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * Created by liuyang on 2015/6/27.
 */
public class UserClientController extends BaseController {

    public void index() {
        String token = getPara("token");
        String method = getRequest().getMethod();
        if(method.equalsIgnoreCase(Constants.RequestMethod.POST)) {
            if (StrUtil.isBlank(token)) {
                error(Constants.ResultDesc.FAILURE);
            } else {
                Map<String, Object> map = new HashMap<String, Object>();
                User user = User.me.findByToken(token);
                map.put("user", user);
                if (user == null) {
                    error(Constants.ResultDesc.FAILURE);
                } else {
                    List<Topic> topics = Topic.me.paginateByAuthorId(1, 10, user.getStr("id")).getList();
                    map.put("topics", topics);
                    List<Collect> collects = Collect.me.findByAuthorIdWithTopic(user.getStr("id"));
                    map.put("collects", collects);
                    success(map);
                }
            }
        } else {
            error("请使用post请求");
        }
    }
}
