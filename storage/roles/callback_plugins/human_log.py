FIELDS = ['stdout']
url="http://test.com/jobs/run/"
import requests
import json

pid=-1
class CallbackModule(object):
    def playbook_on_play_start(self, pattern):
        global pid
        pid = self.play.vars.get("pid")
        requests.post(url+str(pid),
            data = {"pname":pattern,"name":"play_start"})
    def playbook_on_task_start(self, name, is_conditional):
        requests.post(url+str(pid),
            data = {"tname":name,"name":"task_start"})
    def runner_on_no_hosts(self):
		requests.post(url+str(pid),
            data = {"name":"no_hosts"})
    def playbook_on_no_hosts_matched(self):
		requests.post(url+str(pid),
            data = {"name":"no_hosts_matched"})
    def runner_on_unreachable(self, host, res):
		requests.post(url+str(pid),
            data = {"host":host,"name":"unreachable","res":res})
    def runner_on_failed(self, host, res):
		requests.post(url+str(pid),
            data = {"host":host,"name":"failed","res":res})
    def runner_on_skipped(self, host, item=None):
		requests.post(url+str(pid),
            data = {"host":host,"name":"skipped"})
    def runner_on_ok(self, host, res):
        requests.post(url+str(pid),
            data = {"host":host,"name":"ok","changed":res.get("changed")})
    def playbook_on_stats(self, stats):
        list=[]
        for key in stats.processed:
            tmp={
                    "host":key, "ok":stats.ok.get(key),
                    "failures":stats.failures.get(key),
                    "dark":stats.dark.get(key),
                    "skipped":stats.skipped.get(key),
                    "changed":stats.changed.get(key)
                }
            list.append(tmp)
        requests.post(url+str(pid),
            data = {"data":json.dumps(list),"name":"on_stats"})